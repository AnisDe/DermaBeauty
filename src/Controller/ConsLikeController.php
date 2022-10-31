<?php

namespace App\Controller;

use App\Entity\ConsLike;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsLikeController extends AbstractController
{
    /**
     * @Route("/cons/like", name="cons_like")
     */
    public function index(): Response
    {
        return $this->render('cons_like/index.html.twig', [
            'controller_name' => 'ConsLikeController',
        ]);
    }
    /**
     * @Route("/affichL", name="affichL")
     */
    public function list()
    {
        $likes= $this->getDoctrine()->getRepository(ConsLike::class)->findAll();

        return $this->render('cons_like/index.html.twig', [
            "likes" => $likes,]);

    }

}
