<?php

namespace App\Controller;

use App\Entity\FormCateg;
use App\Entity\Formulaire;
use App\Form\FormCategType;
use App\Form\FormulaireType;
use App\Repository\FormCategRepository;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FormCategController extends AbstractController
{ /**
 * @Route("/affichFC", name="affichFC")
 */
    public function list()
    {
        $formcs = $this->getDoctrine()->getRepository(FormCateg::class)->findAll();

        return $this->render('form_categ/list.html.twig', [
            "formcs" => $formcs,]);

    }
    /**
     * @Route("/affichFCf", name="affichFCf")
     *
     *
     */
    public function listf()
    {
        $formcs = $this->getDoctrine()->getRepository(FormCateg::class)->findAll();

        return $this->render('form_categ/list_front.html.twig', [
            "formcs" => $formcs,]);

    }

    /**
     * @Route("/formC/supp/{id_cat}", name="supprimerFC")
     */
    public function supprimer($id_cat)
    {
        $formcs = $this->getDoctrine()->getRepository(FormCateg::class)->find($id_cat);
        $em = $this->getDoctrine()->getManager();
        $em->remove($formcs);
        $em->flush();
        return $this->redirectToRoute('affichFC');
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("formC/ajoutFC", name="ajoutFC")
     */
    function ajout(Request $request)
    {
        $formc = new FormCateg();
        $form = $this->createForm( FormCategType::class, $formc);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($formc);

            $em->flush();
            return $this->redirectToRoute('affichFC');
        }
        return $this->render('form_categ/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @route ("formC/modifier/{id_cat}", name="modifierFC")
     */
    function modifier(FormCategRepository  $repository, Request $request, $id_cat)
    {
        $formc = $repository->find($id_cat);
        $form = $this->createForm(FormCategType::class, $formc);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affichFC');
        }
        return $this->render('form_categ/modifier.html.twig', [
            'f' => $form->createView()
        ]);
    }
}
