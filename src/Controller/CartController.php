<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(Request $request ,ProduitRepository $repository): Response
    {
        $panier = $request->getSession()->get('panier',[]);
        $panierWithData = [];
        $nb= 0;
        $total = 0;
        foreach ($panier as $id=>$quantite){
            $product = $repository->find($id);
            if(!(is_null($product))){
                $panierWithData[] = [
                    'produit'=>$product,
                    'quantite'=>$quantite

                ];
                $nb+=$quantite;
                $total+=$product->getPrixP()*$quantite;

            }

        }
        //dd($panierWithData);
        return $this->render('cart/index.html.twig',['item'=>$panierWithData,'total'=>$total,'nb'=>$nb]);



    }

    /**
     * @param $id
     * @param Request $request
     * @Route("/cart/add/{id}",name="addCart")
     */
    public function add($id,SessionInterface $session){

        $panier = $session->get('panier',[]);

        if(isset($panier[$id])){
            $panier[$id]++;

        }
        else{
            $panier[$id]=1;
        }
        $session->set('panier',$panier);


        return $this->redirectToRoute('cart');








    }

    /**
     * @param $id
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/cart/remove/{id}",name="cart_remove")
     */
    public function remove($id,SessionInterface $session){
        $panier= $session->get('panier',[]);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('cart');


    }

    /**
     * @param SessionInterface $session
     * @Route("/cart/quantite",name="addCartWith")
     */
    public function addWithQuantity(SessionInterface $session){
        $panier = $session->get('panier',[]);
        if(isset($_GET['nbre']) && isset($_GET['id'])){
            $quantity = $_GET['nbre'];
            $id = $_GET['id'];


        }
        settype($quantity,'integer');
        $panier[$id] = $quantity;
        $session->set('panier',$panier);
        return $this->redirectToRoute('cart');


    }

}
