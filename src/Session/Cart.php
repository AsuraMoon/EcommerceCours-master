<?php

namespace App\Session;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    // 1 création  de ma session
    private $session;
    private $repo;

    public function __construct(SessionInterface $session, ProductRepository $repo)
    {
        $this->session = $session;
        $this->repo = $repo;
    }

    public function add($id)
    {
        // $cart vaut ce que $this->get() contient, sinon un tableau vide.
        $cart = $this->get([]);

        // Si $cart[$id] n'est pas vide alors tu ajoutes +1
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            // Sinon, tu l'ajoutes
            $cart[$id] = 1;
        }

        // J'ai plus cas inserer ma variable $cart dans ma session cart.
        $this->session->set('cart', $cart);
    }

    public function get()
    {
        // permet de recuperer ma session cart
        return $this->session->get('cart') ?? [];
    }

    public function getFullProduct(){
        // Je créer un variable 'fullProduct'
        $fullProduct = [];
        foreach ($this->get() as $id => $quantity) {
            $product = $this->repo->findOneById($id);

            //empeche les mauvais produit
            if(!$product){
                continue;
            }

            $fullProduct[] = [
                'product' => $product,
                'quantity' => $quantity,
            ];

        }
        return $fullProduct;
    }



    public function decrease($id)
    {
        // $cart vaut ce que $this->get() contient, sinon un tableau vide.
        $cart = $this->get([]);
        // Je dois vérifier si ma quantité > 1
        if ($cart[$id] > 1) {
            $cart[$id]--;
            // Si ma valeur égal 1 et que je clique de nouveau
        } else {
            unset($cart[$id]);
        }
        return $this->session->set('cart', $cart);
    }

    public function removeOne($id)
    {
        // $cart vaut ce que $this->get() contient, sinon un tableau vide.
        $cart = $this->get([]);
        // unset() détruit la ou les variables dont le nom a été passé en argument.
        unset($cart[$id]);
        // je retourne ce qu'il reste de $cart.
        return $this->session->set('cart', $cart);
    }

    public function remove()
    {
        // supprime l'ensemble des informations dans ma session 'cart'
        return $this->session->remove('cart');
    }
}
