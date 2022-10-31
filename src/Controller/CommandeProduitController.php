<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Repository\CommandeProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CommandeProduitController extends AbstractController
{
    // /**
    //  * @Route("/commande/produit", name="commande_produit")
    //*/
    /* public function index(): Response
     {
         return $this->render('commande_produit/index.html.twig', [
             'controller_name' => 'CommandeProduitController',
         ]);
     }*/
    /**
     * @Route("/ajouter/commande",name="addCommande")
     */
    public function ajouterCommande(SessionInterface $session, ProduitRepository $repository)
    {
        $panier = $session->get('panier');
        $em = $this->getDoctrine()->getManager();
        $commandeproduit = new CommandeProduit();
        $commande = new Commande();
        $priTot = 0;
        foreach ($panier as $id => $quantity) {

            $produit = $repository->find($id);
            $produit->setQuantiteV($quantity);
            $produit->nvquantite($quantity);
            $commandeproduit->setQuantite($quantity);
            $em->flush();
            $priTot += $quantity * $produit->getPrixP();
            $produit->addCommandeProduit($commandeproduit);
            $commande->addCommandeProduit($commandeproduit);
        }
        $commande->setDate(new\ dateTime());
        $commande->setPrixtotal($priTot);


        // $user = $this->getUser();
        $commande->setUser($this->getUser());//emna
        $em->persist($commande);
        $em->persist($commandeproduit);
        $session->set('panier', []);
        $em->flush();
         return $this->redirectToRoute('affiche_commande');
       // return $this->render('commande_produit/index.html.twig');

    }


    /**
     * @param CommandeRepository $repository
     * * @param CommandeProduitRepository $rep
     * @return Response
     * @Route ("/commande/affiche",name="affiche_commande")
     */
    public function affichecommandeproduit(CommandeRepository $repository,CommandeProduitRepository $rep,SessionInterface $session)
    {
        return $this->render('commande_produit/index.html.twig', ['commande' => $repository->findAll(),
        'commandeproduit'=>$rep->findAll()]);


    }

}