<?php

namespace App\Controller;

use App\Entity\Dermatologue;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\ContactType;
use App\Form\UserType;
use App\Repository\DermatologueRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {


        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $dermatologues = $this->getDoctrine()->getRepository(Dermatologue::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'dermatologues' => $dermatologues
        ]);
    }
    /**
     * @Route("/admin/{id}", name="supprimerU")
     */
    public function supprimer($id)
    {
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin');
    }
    /**
     * @Route("/admin/modifier/{id}", name="modifierU")
     */
    public function editUser(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->add('Modifier',SubmitType::class) ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edituser.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/contact/{id}", name="contact")
     */
    public function email(Request $request, $id, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom($user->getEmail())
                // On attribue le destinataire
                ->setTo($contact['email'])
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'contact/email.html.twig',compact('contact','user')),
                    'text/html')
            ;
            $mailer->send($message);
            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.'); // Permet un message flash de renvoi
            return $this->redirectToRoute('admin');

        }
        return $this->render('contact/index.html.twig',['contactForm' => $form->createView()]);
    }
    /**
     * @Route("/stat", name="stat")
     */
    public function statistiques (DermatologueRepository $repository){
        $users= $this->getDoctrine()->getRepository(Dermatologue::class)->findAll();

        //$user1[] =$this->getDoctrine()->getRepository(Dermatologue::class)->count(['categorie'=>$users->getCategorie()]);
        $userName =[];
        $userAdress=[];
        $userCount=[];
        foreach ($users as $user ){
            $userName[]= $user->getNom();
            $userAdress[]=$user->getAdresse();
            $userCount[]=count(['categorie'=>$user->getCategorie()->getNomCat()]);

        }
        $produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        $prodnom=[];
        // $prodquantite=[];
        // $prodvendu=[];
        $pourcentage=[];
        $prodcouleur=[];
        //  $prodcath=[];
        foreach ($produits as $prod){
            $prodnom[]= $prod->getNomP();
            //  $prodquantite[]=$prod->getQuantiteP();
            // $prodvendu[]= $prod->getQuantiteV();
            $pourcentage[]=$prod->vente();
            $prodcouleur[]= $prod->getCouleur();
            // $prodcath[]=$prod->getCategorie();
        }
        return $this->render('statistique/stat.html.twig',[
            'userName'=>json_encode($userName),
            'userAdress'=>json_encode($userAdress),
            'userCount'=>json_encode($userCount),
            'prodnom'=>json_encode($prodnom),
            'pourcentage'=>json_encode($pourcentage),
            //'prodquantite'=>json_encode($prodquantite),
            //'prodvendu'=>json_encode($prodvendu),
            'prodcouleur'=>json_encode($prodcouleur),
            // 'prodcath'=>json_encode($prodcath)

        ]);
    }

}
