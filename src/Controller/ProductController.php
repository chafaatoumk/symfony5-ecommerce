<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findSearch();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product-detail")
     */
    public function show(Product $id, ProductRepository $productRepository, Request $requestr): Response
    {
        $product = $productRepository
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No Property found for id '.$id
            );
        }

        // render a template
        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
