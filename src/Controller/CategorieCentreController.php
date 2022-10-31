<?php

namespace App\Controller;

use App\Entity\CategorieCentre;
use App\Form\CategorieCentreType;
use App\Repository\CategorieCentreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/centre")
 */
class CategorieCentreController extends AbstractController
{
    /**
     * @Route("/", name="categorie_centre_index", methods={"GET"})
     */
    public function index(CategorieCentreRepository $categorieCentreRepository): Response
    {
        return $this->render('categorie_centre/index.html.twig', [
            'categorie_centres' => $categorieCentreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_centre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieCentre = new CategorieCentre();
        $form = $this->createForm(CategorieCentreType::class, $categorieCentre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieCentre);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_centre_index');
        }

        return $this->render('categorie_centre/new.html.twig', [
            'categorie_centre' => $categorieCentre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_centre_show", methods={"GET"})
     */
    public function show(CategorieCentre $categorieCentre): Response
    {
        return $this->render('categorie_centre/show.html.twig', [
            'categorie_centre' => $categorieCentre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_centre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieCentre $categorieCentre): Response
    {
        $form = $this->createForm(CategorieCentreType::class, $categorieCentre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_centre_index');
        }

        return $this->render('categorie_centre/edit.html.twig', [
            'categorie_centre' => $categorieCentre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_centre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieCentre $categorieCentre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieCentre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieCentre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_centre_index');
    }
}
