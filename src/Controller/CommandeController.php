<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/afficherC", name="afficher_C")
     */

    public function afficher(Request $request)
    {
        $limit=4;
        $page=(int)$request->query->get("page",1);
        $commandes = $this->getDoctrine()->getRepository(Commande::class)->getPaginateCom($page,$limit);
        $total=$this->getDoctrine()->getRepository(Commande::class)->getTotalCom();

        //$produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('commande/afficher.html.twig', [
            'commandes' => $commandes,'limit'=>$limit,'page'=>$page,'total'=>$total]);
    }
    /**
     * @Route("/supprimerC/{id}", name="supprimer_C")
     */
    public function supprimer($id)
    {
        $commandes=$this->getDoctrine()->getRepository(Commande::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($commandes);
        $em->flush();
        return $this->redirectToRoute('afficher_C');
    }
    /**
     * @Route("ajouterC", name="ajouter_C")
     */
    function ajouter(Request $request ) {
        $commandes=new Commande();
        $form=$this->createForm(CommandeType::class,$commandes);
        $form->add('Ajouter',SubmitType::class,['attr'=>['formnovalidate'=>'formnovalidate']]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager() ;
            $em->persist($commandes);
            $em->flush();
            return $this->redirectToRoute('afficher_C');
        }
        return $this->render('commande/ajouter.html.twig',['formajoutc'=>$form->createView()]);
    }
    /**
     * @Route("modifierC/{id}",name="modifier_C")
     */
    public function Modifier($id,Request $request)
    {
        $commandes=$this->getDoctrine()->getRepository(Commande::class)->find($id);
        $form=$this->createForm(CommandeType::class,$commandes);
        $form->add('Modifier',SubmitType::class,['attr'=>['formnovalidate'=>'formnovalidate']]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager() ;
            $em->flush();
            return $this->redirectToRoute('afficher_C');
        }
        return $this->render('commande/modifier.html.twig',['formmodificationc'=>$form->createView()]);
    }

  //  /**
    // * @Route("/ajouter/commande",name="addCommande")
     //*/
    /*public function ajouterCommande(SessionInterface $session,ProduitRepository $repository){
        $panier = $session->get('panier');
        $em = $this->getDoctrine()->getManager();
        $commande = new Commande();
        $priTot = 0;
        foreach ($panier as $id=>$quantity){

            $produit = $repository->find($id);
            $produit->setQuantiteV($quantity);
            $produit->nvquantite($quantity);
            $em->flush();
            $priTot += $quantity * $produit->getPrixP();
            $commande->addProduit($produit);
        }
        $commande->setDate(new\ dateTime());
        $commande->setPrixtotal($priTot);


       // $user = $this->getUser();
       $commande->setUser($this->getUser());//emna
       $em->persist($commande);
       $session->set('panier',[]);
       $em->flush();
       return $this->redirectToRoute('affiche_commande');




    }

    /**
     * @param CommandeRepository $repository
     * @return Response
     * @Route ("/commande/affiche",name="affiche_commande")
     */
   /* public function afficheCommande(CommandeRepository $repository,SessionInterface $session){
        return $this->render('commande/affichefront.html.twig',['commande'=>$repository->findAll()]);


    }*/



}
