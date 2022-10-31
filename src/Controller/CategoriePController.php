<?php

namespace App\Controller;

use App\Entity\CategorieP;
use App\Entity\Produit;
use App\Repository\CategoriePRepository;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoriePType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Data\SearchProd;
use App\Form\SearchFormProd;

class CategoriePController extends AbstractController
{
    /**
     * @Route("/afficherCP", name="afficher_CP")
     */

    public function afficher(Request $request)
    {
        $limit=4;
        $page=(int)$request->query->get("page",1);
        $categories = $this->getDoctrine()->getRepository(CategorieP::class)->getPaginateCat($page,$limit);
        $total=$this->getDoctrine()->getRepository(CategorieP::class)->getTotalCat();

        //$produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('categorie_p/afficher.html.twig', [
            'categories' => $categories,'limit'=>$limit,'page'=>$page,'total'=>$total]);
    }



    /**
     * @Route("/afficherCPF/{id}", name="afficher_CPF")
     */

    public function afficherf($id,CategoriePRepository $repository,ProduitRepository $produitRepository,Request  $request)
    {
        $data=new SearchProd();
        $form=$this->createForm(SearchFormProd::class,$data);
        $form->handleRequest($request);
        $cath = $repository->find($id);
        $prod = $produitRepository->findBycath($id);


        $cathegorie = $repository->findAll();

        $categories=$this->getDoctrine()->getRepository(CategorieP::class)->findAll();
        return $this->render('produit/afficherfront.html.twig', [
            'categories' => $cathegorie,'produits'=>$prod,'cath'=>$cath,'form'=>$form->createView()]);
    }
    /**
     * @Route("/supprimerCP/{Reference_C}", name="supprimer_CP")
     */
    public function supprimer($Reference_C)
    {
        $categories=$this->getDoctrine()->getRepository(CategorieP::class)->find($Reference_C);
        $em=$this->getDoctrine()->getManager();
        $em->remove($categories);
        $em->flush();
        return $this->redirectToRoute('afficher_CP');
    }
    /**
     * @Route("ajouterCP", name="ajouter_CP")
     */
    function ajouter(Request $request ) {
        $categories=new CategorieP();
        $form=$this->createForm(CategoriePType::class,$categories);
        $form->add('Ajouter',SubmitType::class,['attr'=>['formnovalidate'=>'formnovalidate']]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager() ;
            $em->persist($categories);
            $em->flush();
            return $this->redirectToRoute('afficher_CP');
        }
        return $this->render('categorie_p/ajouter.html.twig',['formajoutC'=>$form->createView()]);
    }
    /**
     * @Route("modifierCP/{Reference_C}",name="modifier_CP")
     */
    public function Modifier($Reference_C,Request $request)
    {
        $categories=$this->getDoctrine()->getRepository(CategorieP::class)->find($Reference_C);
        $form=$this->createForm(CategoriePType::class,$categories);
        $form->add('Modifier',SubmitType::class,['attr'=>['formnovalidate'=>'formnovalidate']]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager() ;
            $em->flush();
            return $this->redirectToRoute('afficher_CP');
        }
        return $this->render('categorie_p/modifier.html.twig',['formmodificationC'=>$form->createView()]);
    }
}
