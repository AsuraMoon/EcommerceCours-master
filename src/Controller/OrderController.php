<?php

namespace App\Controller;

use App\Session\Cart;

use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index(Cart $cart): Response
    {
        $form = $this->createForm(OrderType::class, null,[
            'user' => $this->getUser(),
        ]);
        
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFullProduct(),
        ]);
    }

    /**
     * @Route("/order/recap", name="order_recap")
     */
    public function recap(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(OrderType::class, null,[
            'user' => $this->getUser(),
        ]);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $date = new \DateTime();

            $deliverer = $form->get('carrier')->getData();
            $delivery = $form->get('address')->getData();

            $addressDelivery = $delivery->getFirstName(). ' ' .$delivery->getLastName();

            if ($delivery->getCompany()){
                $addressDelivery .= '<br/>' . $delivery->getCompany();
            };
            $addressDelivery .= '<br/>' . $delivery->getPhone();
            $addressDelivery .= '<br/>' . $delivery->getAddress();
            $addressDelivery .= '<br/>' . $delivery->getPostalCode();
            $addressDelivery .= ',' . $delivery->getCity();
            $addressDelivery .= ' - ' . $delivery->getCountry();
            dd($addressDelivery);

       }

        return $this->render('order/recap.html.twig', [
            'cart' => $cart->getFullProduct(),
        ]);
    }
}
