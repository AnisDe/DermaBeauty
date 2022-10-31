<?php

namespace App\Controller;

use App\Entity\CategorieDerm;
use App\Entity\Dermatologue;
use App\Entity\User;
use App\Form\DermatologueType;
use App\Form\DermMType;
use App\Repository\DermatologueRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DermatologueController extends RegistrationController
{
    /**
     * @Route("/dermatologues", name="dermatologues")
     */
    public function list ()
    {

        $dermatologues = $this->getDoctrine()->getRepository(Dermatologue::class)->findAll();


        return $this->render('dermatologue/affichederm.html.twig', [
            'dermatologues' => $dermatologues,
        ]);
    }

   /**
     * @Route("/dermatologuesfront/affiche/{ref}", name="dermfront")
     */
    public function listfront ($ref)
    {

        $dermatologues = $this->getDoctrine()->getRepository(Dermatologue::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(CategorieDerm::class)->findAll();

        return $this->render('dermatologue/afficherdermatologuefront.html.twig', [
            'dermatologues' => $dermatologues,
            'ref'=> $ref,
            'categories'=> $categories
        ]);
    }

    /**
     * @Route("/dermatologuesfront/affiche1/{id}", name="dermfront1")
     */
    public function listfrontderm ($id)
    {

        $dermatologues = $this->getDoctrine()->getRepository(Dermatologue::class)->find($id);


        return $this->render('dermatologue/afficher1dermatologuefront.html.twig', [
            'dermatologues' => $dermatologues,
            'id'=> $id
        ]);
    }




    /**
     * @Route("/Supderm/{id}", name="derm")
     */
    public function Delete($id,DermatologueRepository $repository)
    {
        $dermatologue=$repository->find($id);

        $em=$this->getDoctrine()->getManager();
        $em->remove($dermatologue);
        $em->flush();

        return $this->redirectToRoute('dermatologues');

    }

   /* /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("dermatologue/Ajoutderm" ,  name="ajoutderm")
     */
   /* function add(Request $request ,UserPasswordEncoderInterface $passwordEncoder) {


        $dermatologues=new Dermatologue();
        $form=$this->createForm(DermatologueType::class,$dermatologues);
        $form->add('Ajouter', SubmitType::class) ;
        $form->handleRequest($request);
        //$dc2array = unserialize($dermatologues->getAssurancemaladie(), ['allowed_classes' => false]);
        //var_dump($dc2array);

        if($form->isSubmitted()&& $form->isValid())
        {
            $path=$this->getParameter('kernel.project_dir').'/public/back/img';
            $dermatologues=$form->getData();
            $file=$dermatologues->getImage();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move($path,$fileName);
            }catch(FileException $e){

            }
            $em=$this->getDoctrine()->getManager() ;
            $dermatologues->setImage($fileName);
            $dermatologues->setPassword(
                $passwordEncoder->encodePassword(
                    $dermatologues,
                    $form->get('password')->getData()
                ));
            $em->persist($dermatologues);

            $em->flush();
            return $this->redirectToRoute('dermatologues');
        }
        return $this->render ('dermatologue/Ajoutderm.html.twig',[
            'form'=>$form->createView()
        ]) ;
    }*/

    /**
     * @Route ("dermatologue/Update/{id}" , name="updatederm")
     */
    function Update(DermatologueRepository $repository,$id,Request $request){
        //$repository = $this->getDoctrine()->getRepository(User::class);
        //$user = $repository->find($id);
        $dermatologues=$repository->find($id);
        $form=$this->createForm(DermMType::class,$dermatologues) ;
        $form->add('Modifier',SubmitType::class) ;
        $form->handleRequest($request) ;

        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager() ;
            $em->flush();
            return $this->redirectToRoute('dermatologues');
        }
        return $this->render('dermatologue/ModifDerm.html.twig',[
            'f'=>$form->createView()
        ]) ;
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("dermatologue/Ajoutu/{id}" ,  name="ajoutdermu")
     */
    function addus(Request $request ,$id) {

        $dermatologues=new Dermatologue();

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);


        //$dermatologues->setId($user->getId());
        $dermatologues->setEmail($user->getEmail());
        $dermatologues->setRoles($user->getRoles());
        $dermatologues->setPassword($user->getPassword());
        $dermatologues->setCin($user->getCin());
        $dermatologues->setNom($user->getNom());
        $dermatologues->setPrenom($user->getPrenom());
        $dermatologues->setAdresse($user->getAdresse());
        $dermatologues->setNumero($user->getNumero());
        $em=$this->getDoctrine()->getManager() ;

        $form=$this->createForm(DermatologueType::class,$dermatologues);

        $form->add('Ajouter', SubmitType::class) ;

        $form->handleRequest($request);
        //$dc2array = unserialize($dermatologues->getAssurancemaladie(), ['allowed_classes' => false]);
        //var_dump($dc2array);

        if($form->isSubmitted()&& $form->isValid())
        {
            $path=$this->getParameter('kernel.project_dir').'/public/back/img';
            $dermatologues=$form->getData();
            $file=$dermatologues->getImage();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move($path,$fileName);
            }catch(FileException $e){

            }

            $dermatologues->setImage($fileName);
            $em->persist($dermatologues);
            $em->flush();
            $this->supprimer($id);


            return $this->redirectToRoute('dermatologues');
        }

        return $this->render ('dermatologue/Ajoutderm.html.twig',[
            'form'=>$form->createView(),

        ]) ;


    }
}
