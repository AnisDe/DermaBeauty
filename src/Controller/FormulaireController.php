<?php

namespace App\Controller;

use App\Entity\FormCateg;
use App\Entity\Formulaire;
use App\Form\FormulaireType;
use App\Repository\FormulaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class FormulaireController extends AbstractController
{
    /**
     * @Route("/affichF", name="affichF")
     */
    public function list(Request $request,FormulaireRepository $repository)
    {   $limit=10;
        $page=(int)$request->query->get("page",1);
        $forms = $repository->getPaginateform($page,$limit);
        $total=$repository->getTotalform();

        return $this->render('formulaire/list.html.twig',compact('forms','total','limit','page'));

    }
    /**
     * @Route("/trier", name="trierparcin")
     */
    public function listpartriecin()
    {
        $forms = $this->getDoctrine()->getRepository(Formulaire::class)->listOrderBycin();

        return $this->render('formulaire/list.html.twig', [
            "forms" => $forms,]);

    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("formulaire_front/ajout/{idcat}", name="ajoutFf")
     */
    function ajoutF (Request $request,$idcat)
    {   /* $cat->setIdCat($idcat);
        $form1->setFormCateg($cat);*/
        $form1 = new Formulaire();

        $form = $this->createForm( FormulaireType::class, $form1);
        $form->add('ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'The form is valid.');
            $em = $this->getDoctrine()->getManager();
            $em->persist($form1);
            $em->flush();
            return $this->redirectToRoute('affichFCf');

        }
        else
        {
            $this->addFlash('error', 'The form is invalid.');
        }
        return $this->render('formulaire/ajout_front.html.twig', [
            'form' => $form->createView(),
            'idcat' => $idcat
        ]);
    }
    /**
     * @Route("/formulaire/supp/{ref}", name="supprimerF")
     */
    public function supprimer($ref)
    {
        $forms = $this->getDoctrine()->getRepository(Formulaire::class)->find($ref);
        $em = $this->getDoctrine()->getManager();
        $em->remove($forms);
        $em->flush();
        return $this->redirectToRoute('affichF');
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("formulaire/ajout", name="ajoutF")
     */
    function ajout(Request $request)
    {
        $form1 = new Formulaire();
        $form = $this->createForm( FormulaireType::class, $form1);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form1);

            $em->flush();
            return $this->redirectToRoute('affichF');
        }
        return $this->render('formulaire/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @route ("formulaire/modifier/{ref}", name="modifierF")
     */
    function modifier(FormulaireRepository $repository, Request $request, $ref)
    {
        $form1 = $repository->find($ref);
        $form = $this->createForm(FormulaireType::class, $form1);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affichF');
        }
        return $this->render('formulaire/modifier.html.twig', [
            'f' => $form->createView()
        ]);
    }
    /**
         * @route ("formulaire/pdf/{ref}", name="PDF")
     */
    function generePDF(FormulaireRepository $repository,$ref)
    {
        // Configure Dompdf according to your needs

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');


        $form = $repository->find($ref);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/pdf.html.twig', [
            'form' => $form
        ]);
        //$html .= '';
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("formulaire.pdf", [
            "Attachment" => true
        ]);
    }
    /**
     * @Route("/recherche", name="recherche")
     */
    public function searchcin(Request $request)
    {

        $data = $request->request->get('search');

        $forms= $this->getDoctrine()->getRepository(Formulaire::class)->rechercher($data);

        return $this->render('formulaire/affich_back_rech.html.twig', [
            'forms' => $forms,
        ]);
    }

}
