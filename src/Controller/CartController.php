<?php

namespace App\Controller;

use App\Session\Cart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart ->getFullProduct(),
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="add_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_cart")
     */
    public function decrease(Cart $cart, $id)
    {
        $cart->decrease($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove/{id}", name="remove_one_cart")
     */
    public function removeOneCart(Cart $cart, $id)
    {
        $cart->removeOne($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove_cart")
     */
    public function remove(Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('cart');
    }

}
