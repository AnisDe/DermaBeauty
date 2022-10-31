<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Forum;
use App\Entity\Reply;
use App\Entity\ReplyLike;
use App\Entity\Signal;
use App\Form\ForumType;
use App\Form\ReplyType;
use App\Form\SearchForm;
use App\Form\SearchType;
use App\Repository\ForumRepository;
use App\Repository\ReplyLikeRepository;
use App\Repository\ReplyRepository;
use App\Repository\SignalRepository;
use App\Repository\SujetRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Faker\Provider\DateTime;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index(ForumRepository $repository,Request $request,SujetRepository $sujetRepository): Response
    {
        $data = new SearchData();
        $sujets = $sujetRepository->findAll();

        $data->page= $request->get('page',1);
        $form=$this->createForm(SearchType::class,$data);
        if($request->isXmlHttpRequest()){
            if(isset($_GET['cath_id'])){
              $data->cat_id = $_GET['cath_id'];
            }

            if(isset($_GET['q'])){

                $data->q = $_GET['q'];
            }
            if(isset($_GET['page'])){

                $data->page =$_GET['page'];
            }



            return $this->json(['forums'=>$this->renderView('forum/forums.html.twig',['forum'=>$repository->selectData($data)]),'page'=>$this->renderView('forum/pagination.html.twig',['forum'=>$repository->selectData($data)])]);
        }
$form->handleRequest($request);

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController','forum'=>$repository->selectData($data),'form'=>$form->createView(),'sujet'=>$sujets
        ]);
    }

    /**
     * @Route("/ala/aff/{id}", name="afficher_forum_with_cath")
     */
    public function forumFilter(ForumRepository $repository,Request $request,SujetRepository $sujetRepository,$id): Response
    {
        $data = new SearchData();
        $sujets = $sujetRepository->findAll();

        $data->page= $request->get('page',1);
        $form=$this->createForm(SearchForm::class,$data);
        $form->handleRequest($request);

        return $this->render('forum/index.html.twig', [
            'forum'=>$repository->selectDataWithSujet($data,$id),'form'=>$form->createView(),'sujet'=>$sujets
        ]);
    }

    /**
     * @param $id
     * @param ForumRepository $repository
     * @return Response
     * @Route ("/forum/show/{id}",name="forum_show")
     */
    public function showForum($id,ReplyLikeRepository $likeRepository, ForumRepository $repository,Request $request,ReplyRepository $replyRepository,SignalRepository $signalRepository){
        if(isset($_GET['raison'])){


              $signal = new Signal();
            $rep = $replyRepository->find($_GET['rep_id']);
            $signal->setReply(($rep));
            $signal->setContent($_GET['raison']);
            $signal->setUser($this->getUser());
            if($rep->isSignaledByUser($this->getUser())){
                return $this->json(['ala'=>'vou avez deja signalez'],403);


            }
            else{
                $em = $this->getDoctrine()->getManager();
                $em->persist($signal);
                $em->flush();
                return $this->json(['ala'=>'votre signal est ajouter avec succes'],200);

            }

            //$sig = $signalRepository->findBy(['user'=>$this->getUser(),'reply'=>$rep]);

            //else{


            //}


        }

        $forum = $repository->find($id);
        if (isset($_GET['contenu'])){

                $reply = new Reply();
                $reply->setContent($_GET['contenu']);
                $reply->setForum($forum);
                $reply->setUser($this->getUser());
                $reply->setCreationDate(new \DateTime);
                $em = $this->getDoctrine()->getManager();
                $em->persist($reply);
                $em->flush();




            return $this->json(['id'=>$reply->getId(),'message'=>$reply->getContent(),'username'=>$reply->getUser()->getUsername(),'forumId'=>$reply->getForum()->getId(),'creationDate'=>$reply->getCreationDate()]);



        }

        $reps = $forum->getReplies();

        return $this->render('forum/show.html.twig',['forum'=>$forum,'reps'=>$reps]);





    }

    /**
     * @param ReplyRepository $repository
     * @param ForumRepository $forumRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route ("/forum/updat/{id}",name="update_response")
     */
    public function UpdateReponse(ReplyRepository $repository,ForumRepository $forumRepository,$id,Request $request){
        $forum = $forumRepository->find($id);
        if($request->isXmlHttpRequest()){
            if (isset($_GET['cont']) && isset($_GET['id_response'])){
                $id_response = $_GET['id_response'];
                $content = $_GET['cont'];
                $reply = $repository->find($_GET['id_response']);
                $reply->setContent($_GET['cont']);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }






        }

            //$replies = $forum->getReplies();

            return $this->json(['id_res'=>$id_response,'cont'=>$content]);








    }


    /**
     * @param ForumRepository $repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/forum/rem/{id}",name="delete_forum")
     */

    public function deleteForum(ForumRepository $repository,$id){
    $forum = $repository->find($id);
    $manager = $this->getDoctrine()->getManager();
    $manager->remove($forum);
    $manager->flush();
    return $this->redirectToRoute('forum');


    }



    /**
     * @param $id
     * @param Request $request
     * @param ForumRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/forum/edit/{id}",name="edit_forum")
     */
    public function editForum($id,Request $request,ForumRepository $repository){
        $forum = $repository->find($id);
        $form = $this->createForm(ForumType::class,$forum);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $forum->setCreationDate(new \DateTime());
            $forum->setUser($this->getUser());
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('forum');

        }
        return $this->render('forum/newForum.html.twig',['form'=>$form->createView()]);



    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/forum/add",name="add_forum")
     */
    public function AddForum(Request $request){
        $forum = new Forum();
        $form = $this->createForm(ForumType::class,$forum);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $forum->setCreationDate(new \DateTime());
            $forum->setUser($this->getUser());
            $em= $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('forum');

        }
        return $this->render('forum/newForum.html.twig',['form'=>$form->createView()]);



    }

    /**
     * @param Reply $reply
     * @param ReplyLikeRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/reply/like/{id}",name="like_reply")
     */

    public function like(Reply $reply,ReplyLikeRepository $repository){
    $user = $this->getUser();

    $manager = $this->getDoctrine()->getManager();
    if(!$user){
        return $this->json(['status'=>'not authorised'],403);


    }

       else if($reply->isLikedByUser($user)){

           $like = $repository->findOneBy(['user'=>$user,'reply'=>$reply]);
            $manager->remove($like);
            $manager->flush();
           return $this->json(['like'=>'cotre like va etre supprimer','nblikes'=>$repository->count(['reply'=>$reply])],200);
       }
       else {
           $like = new ReplyLike();
$like->setReply($reply);
$like->setUser($user);
       $manager->persist($like);
        $manager->flush();
           return $this->json(['like'=>'vous avez likez ce reply','nblikes'=>$repository->count(['reply'=>$reply])],200);

       }





    }

    /**
     * @param $id
     * @param ReplyRepository $repository
     * @Route("/forum/reply/remove/{id}",name="deleteRep")
     */
    public function deleteReply($id , ReplyRepository $repository,ForumRepository $forumRepository){
        $reply = $repository->find($id);
        $ident = $reply->getForum()->getId();
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($reply);
        $manager->flush();
        return $this->redirectToRoute('forum_show',['id'=>$ident]);
        //return $this->render('forum/show.html.twig',['forum'=>$forumRepository->find($ident)]);


    }

}
