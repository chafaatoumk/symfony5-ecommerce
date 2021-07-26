<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id)
    {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id]))
        {
            $cart[$id]++;
        }
        else{
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function remove(int $id)
    {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id]))
        {
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);
    }

    public function getFullCart() : array
    {
        $cart = $this->session->get('cart', []);
        $cartWithData = [];

        foreach($cart as $id => $quantity)
        {
            $cartWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity,
                'discountItem' => ($this->productRepository->find($id)->getPrice() * $quantity * 0.1) / 100,
                'totalItem' => ($this->productRepository->find($id)->getPrice() * $quantity) 
                                + ($this->productRepository->find($id)->getPrice() * $quantity * 0.1) / 100,
            ];
        }

        return $cartWithData;
    }

    public function getTotal() : float
    {
        $total = 0;

        foreach($this->getFullCart() as $item)
        {
            $total += $item['totalItem'];
        }

        return $total;
    }
}