<?php

namespace App\Controller;
use App\entity\ConsLike;
use App\Entity\Conseil;
use App\Form\ConseilType;
use App\Repository\ConseilRepository;

use App\Repository\ConsLikeRepository;
use Doctrine\Persistence\ObjectManager;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
class ConseilController extends AbstractController
{
    /**
     * @Route("/conseil", name="conseil")
     */
    public function index(): Response
    {
        return $this->render('conseil/index.html.twig', [
            'controller_name' => 'ConseilController',
        ]);
    }

    /**
     * @Route("/affichO", name="affichO")
     */
    public function list()
    {
        $conseils = $this->getDoctrine()->getRepository(Conseil::class)->findAll();

        return $this->render('Conseil/list.html.twig', [
            "conseils" => $conseils,]);

    }
    /**
     * @Route("/trier/conseil", name="trierpardate")
     */
    public function listpartrie()
    {
        $conseils = $this->getDoctrine()->getRepository(Conseil::class)->listOrderBydate();

        return $this->render('conseil/list.html.twig', [
            "conseils" => $conseils,]);

    }
    /**
     * @Route("/affichOf", name="affichOf")
     */
    public function listf()
    {
        $conseils = $this->getDoctrine()->getRepository(Conseil::class)->findAll();

        return $this->render('Conseil/list_front.html.twig', [
            "conseils" => $conseils,]);

    }
    /**
     * @Route("/conseil/supp/{reference}", name="supprimerO")
     */
    public function supprimer($reference)
    {
        $conseil = $this->getDoctrine()->getRepository(Conseil::class)->find($reference);
        $em = $this->getDoctrine()->getManager();
        $em->remove($conseil);
        $em->flush();
        return $this->redirectToRoute('affichO');
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("conseil/ajout", name="ajoutO")
     */
    function ajout(Request $request)
    {
        $conseil = new Conseil();
        $form = $this->createForm( ConseilType::class, $conseil);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conseil);

            $em->flush();
            return $this->redirectToRoute('affichO');
        }
        return $this->render('conseil/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("conseil/modifier/{reference}", name="modifierO")
     */
    function modifier(ConseilRepository $repository, Request $request, $reference)
    {
        $conseils = $repository->find($reference);
        $form = $this->createForm(ConseilType::class, $conseils);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affichO');
        }
        return $this->render('conseil/modifier.html.twig', [
            'f' => $form->createView()
        ]);
    }

    /**
     * @Route("/conseil/like/{reference}", name="conseil_like")
     * @param Conseil $conseil
     * @param ObjectManager $manager
     * @param ConsLikeRepository $likeRep
     * @return Response
     */
    public function like (Conseil $conseil, ConsLikeRepository $likeRep) : Response
    {    $em= $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message'=>"pas autorise"
        ], 403 );
        if ($conseil->islikedByUser($user))
        {
            $like = $likeRep->findOneBy(['conseil'=>$conseil,'user'=>$user]);

            $em->remove($like);
            $em->flush();
            return $this->json([
                'code'=>200,'message'=>'like supprimé','likes'=>$likeRep->count(['conseil'=>$conseil])
            ],200);

        }
            $like= new ConsLike();
            $like->setConseil($conseil)
                ->setUser($user);
            $em->persist($like);
            $em->flush();
            return $this->json(['code'=>200, 'message'=> 'like ajoutee','likes'=>$likeRep->count(['conseil'=>$conseil])],200);

    }
    /**
     * @Route("/recherche/conseil", name="recherche_ref")
     */
    public function searchref(Request $request)
    {

        $data = $request->request->get('search');

        $conseils= $this->getDoctrine()->getRepository(Conseil::class)->rechercher_ref($data);

        return $this->render('conseil/affich_back_cons.html.twig', [
            'conseils' => $conseils,
        ]);
    }
    /**
     * @route ("conseil/pdf/{reference}", name="PDF_O")
     */
    function generePDF(ConseilRepository $repository,$reference)
    {
        // Configure Dompdf according to your needs

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');


        $ordo= $repository->find($reference);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/pdf_O.html.twig', [
            'ordo' => $ordo
        ]);
        //$html .= '';
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("ordonnance.pdf", [
            "Attachment" => true
        ]);
    }
}
