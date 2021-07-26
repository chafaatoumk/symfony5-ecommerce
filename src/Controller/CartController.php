<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart-add")
     */
    public function add($id, CartService $cartService)
    {
        $cartService->add($id);
        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/remove/{id}", name="cart-remove")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        return $this->redirectToRoute('cart');
    }
}
