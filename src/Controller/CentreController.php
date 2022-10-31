<?php

namespace App\Controller;

use App\Entity\CategorieCentre;
use App\Entity\Centre;
use App\Data\Search;
use App\Form\CentreType;
use App\Form\SearchForm;
use App\Form\SearchType;
use App\Repository\CentreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/centre")
 */
class CentreController extends AbstractController
{


    /**
     * @Route("/", name="centre_index")
     */
    public function index(CentreRepository $centreRepository , Request $request ): Response
    {

        $data = new Search();
        $form = $this->createForm(SearchForm::class,$data);
        $form->handleRequest($request);

        $centre = $centreRepository->findSearch($data);
        if ($request->isXmlHttpRequest()){
            return new JsonResponse([
                'content' => $this->renderView('front/centre/_centres.html.twig' , ['centres' =>  $centre])
            ]);
        }
        return $this->render('/front/centre/index.html.twig', [
            'centres' =>  $centre,
            'form'=>$form->createView()

        ]);
    }


    /**
     * @Route("/new", name="centre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $centre = new Centre();
        $form = $this->createForm(CentreType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($centre);
            $entityManager->flush();

            return $this->redirectToRoute('centre_index');
        }

        return $this->render('/front/centre/new.html.twig', [
            'centre' => $centre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="centre_show" )
     */
    public function show(Centre $centre): Response
    {
        return $this->render('front/centre/show.html.twig', [
            'centre' => $centre
        ]);
    }

    /**
     * @Route("/{id}/edit", name="centre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Centre $centre): Response
    {
        $form = $this->createForm(CentreType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('centre_index');
        }

        return $this->render('/front/centre/edit.html.twig', [
            'centre' => $centre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="centre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Centre $centre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($centre);
            $entityManager->flush();
            
        }

        return $this->redirectToRoute('centre_index');
    }


}
