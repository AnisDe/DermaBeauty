<?php

namespace App\Controller;

use App\Entity\CategorieDerm;
use App\Form\CategorieDermType;
use App\Repository\CategorieDermRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategorieDermController extends AbstractController
{
    /**
 * @Route("/dermatologuecat", name="dermatologuecat")
 */
    public function list (Request $request)
    {
        $limit=10;
        $page=(int)$request->query->get("page",1);
        $dermatologuecat = $this->getDoctrine()->getRepository(CategorieDerm::class)->getPaginateCat($page,$limit);
        $total=$this->getDoctrine()->getRepository(CategorieDerm::class)->getTotalCat();


        return $this->render('categorie_derm/affichecatderm.html.twig',compact('dermatologuecat','total','limit','page'));
    }


    /**
     * @Route("/dermatologuescat/front", name="dermatologuesfront")
     */
    public function listfront ()
    {

        $dermatologues = $this->getDoctrine()->getRepository(CategorieDerm::class)->findAll();


        return $this->render('categorie_derm/affichedermfront.html.twig', [
            'dermatologuecat' => $dermatologues,
        ]);
    }

    /**
     * @Route("/Supdermcat/{ref}", name="dermcat")
     */
    public function Delete($ref ,CategorieDermRepository $repository)
    {
        $dermatologuecat=$repository->find($ref);
        $em=$this->getDoctrine()->getManager();
        $em->remove($dermatologuecat);
        $em->flush();

        return $this->redirectToRoute('dermatologuecat');

    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("catdermatologue/Ajoutdermcat" , name="ajoutdermcat")
     */
    function add(Request $request ) {
        $dermatologuecat=new CategorieDerm();
        $form=$this->createForm(CategorieDermType::class,$dermatologuecat);
        $form->add('Ajouter', SubmitType::class) ;
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager() ;
            $em->persist($dermatologuecat);
            $em->flush();
            return $this->redirectToRoute('dermatologuecat');
        }
        return $this->render ('categorie_derm/Ajoutdermcat.html.twig',[
            'form'=>$form->createView()
        ]) ;
    }

    /**
     * @Route ("catdermatologue/Update/{ref}" , name="updatedermcat")
     */

    function Update(CategorieDermRepository $repository,$ref,Request $request){
        $dermatologuecat=$repository->find($ref);
        $form=$this->createForm(CategorieDermType::class,$dermatologuecat) ;
        $form->add('Modifier',SubmitType::class) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager() ;
            $em->flush();
            return $this->redirectToRoute('dermatologuecat');
        }
        return $this->render('categorie_derm/ModifDermcat.html.twig',[
            'f'=>$form->createView()
        ]) ;
    }


}
