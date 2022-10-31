<?php

namespace App\Controller;
use App\Data\SearchProd;
use App\Form\SearchFormProd;
use App\Entity\Produit;
use App\Repository\CategoriePRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProduitType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;





class ProduitController extends AbstractController
{

    /**

 *
 * @Route("/afficherPF/{Reference_C}", name="afficher_PF")
 */

    public function afficherfront($Reference_C)
    {
        $produits=$this->getDoctrine()->getRepository(Produit::class)->OrderBySale();
        return $this->render('produit/afficherfront.html.twig', [

            'produits' => $produits,
            'ReferenceC'=>$Reference_C]);
    }
    /**
     * @param Response
     * @Route("/afficherPF", name="afficher_TPF")
     */

    public function afficherAvecCath(CategoriePRepository $repository,Request  $request)
    {
        $data=new SearchProd();
        $form=$this->createForm(SearchFormProd::class,$data);
        $form->handleRequest($request);
        $produits=$this->getDoctrine()->getRepository(Produit::class)->findsearch($data);
       // $produits=$paginator->paginate(
         //   $data,$request->query->getInt('page',1),24
      //  );
        return $this->render('produit/afficherfront.html.twig', [
            'produits' => $produits
            ,'categories'=>$repository->findAll(),'cath'=>'all','form'=>$form->createView()]);
    }


    /**
     * @Route("/afficherP", name="afficher_P")
     */
    public function afficher(Request $request)
    {
        $limit=4;
        $page=(int)$request->query->get("page",1);
        $produits = $this->getDoctrine()->getRepository(Produit::class)->getPaginateProd($page,$limit);
        $total=$this->getDoctrine()->getRepository(Produit::class)->getTotalProd();

        //$produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('produit/afficher.html.twig', [
            'produits' => $produits,'limit'=>$limit,'page'=>$page,'total'=>$total]);
    }

    /**
     * @Route("/supprimerP/{Reference_P}", name="supprimer_P")
     */
    public function supprimer($Reference_P)
    {
        $produits=$this->getDoctrine()->getRepository(Produit::class)->find($Reference_P);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produits);
        $em->flush();
        return $this->redirectToRoute('afficher_P');
    }
    /**
     * @Route("ajouterP", name="ajouter_P")
     */
    function ajouter(Request $request ) {
        $produits=new Produit();
        $form=$this->createForm(ProduitType::class,$produits);
        $form->add('Ajouter',SubmitType::class,['attr'=>['formnovalidate'=>'formnovalidate']]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $file=$produits->getImageP();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            try{
                $file->move(
                    $this->getParameter('kernel.project_dir'). '/public/back/img',
                    $fileName
                );
            } catch(FileException $e){
                // ...handle exception
            }
            $em=$this->getDoctrine()->getManager() ;
            $produits->setImageP($fileName);
            $em->persist($produits);
            $em->flush();
            return $this->redirectToRoute('afficher_P');
        }
        return $this->render('produit/ajouter.html.twig',['formajoutP'=>$form->createView()]);
    }
    /**
     * @Route("modifierP/{Reference_P}",name="modifier_P")
     */
    public function Modifier($Reference_P,Request $request  )
    {
        $produits=$this->getDoctrine()->getRepository(Produit::class)->find($Reference_P);
        $form=$this->createForm(ProduitType::class,$produits);
        $form->add('Modifier',SubmitType::class,['attr'=>['formnovalidate'=>'formnovalidate']]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager() ;
            $em->flush();
            return $this->redirectToRoute('afficher_P');
        }
        return $this->render('produit/modifier.html.twig',['formmodificationP'=>$form->createView()]);
    }
//panier
    /**
     * @Route("/product", name="product")
     */
    public function index(ProduitRepository $repository,SessionInterface $session): Response
    {
        $panier = $session->get('panier',[]);
        $nb= 0;
        foreach ($panier as $id=>$quantite){
            $nb+=$quantite;

        }

        /**
         * @Route("/afficherP", name="afficher_P")
         */






        return $this->render('product/index.html.twig', [
            'produit' => $repository->findAll(),'nb'=>$nb
        ]);
    }

    /**
     * @param $id
     * @param SessionInterface $session
     * @param ProduitRepository $repository
     * @Route("/product/single/{id}",name="product_single")
     */
    public function single($id,SessionInterface $session,ProduitRepository $repository){
        $panier= $session->get('panier',[]);
        $nb=0;
        foreach ($panier as $idd=>$quantite){
            $nb+=$quantite;

        }
        if(empty($panier[$id])){
            $panier[$id]=1;

        }


        return  $this->render('produit/single.html.twig',[
            'product'=>$repository->find($id),'nb'=>$nb,'quantity'=>$panier[$id]
        ]);


    }
    /**
     * @Route("afficher/PF",name="afficher_M")
     */
    public function afficherMarque($marque)
    {
        $produits=$this->getDoctrine()->getRepository(Produit::class)->findBy($marque);
        return $this->render('produit/afficher.html.twig', [
            'produits' => $produits,
            'marque'=>$marque]);
    }
    /**
     * @Route("/stats",name="stats")
     */
    public function stat1()
    { $produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
    $prodnom=[];
   // $prodquantite=[];
   // $prodvendu=[];
    $pourcentage=[];
    $prodcouleur=[];
      //  $prodcath=[];
    foreach ($produits as $prod){
        $prodnom[]= $prod->getNomP();
      //  $prodquantite[]=$prod->getQuantiteP();
       // $prodvendu[]= $prod->getQuantiteV();
        $pourcentage[]=$prod->vente();
        $prodcouleur[]= $prod->getCouleur();
       // $prodcath[]=$prod->getCategorie();
    }
        return $this->render('statistique/stat.html.twig',[
            'prodnom'=>json_encode($prodnom),
            'pourcentage'=>json_encode($pourcentage),
            //'prodquantite'=>json_encode($prodquantite),
            //'prodvendu'=>json_encode($prodvendu),
            'prodcouleur'=>json_encode($prodcouleur),
           // 'prodcath'=>json_encode($prodcath)
        ]);
    }


}
