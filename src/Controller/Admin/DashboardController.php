<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Comment;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    protected $userRepository;
    protected $productRepository;
    protected $categoryRepository;
    protected $commentRepository;

    public function __construct(
        UserRepository $userRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        CommentRepository $commentRepository 
    )
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'countAllUsers' => $this->userRepository->countAllUsers(),
            'countAllCategories' => $this->categoryRepository->countAllCategories(),
            'countAllProducts' => $this->productRepository->countAllProducts(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Turkish Shop');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-users', Product::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Comments', 'fas fa-comment', Comment::class);
        //yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
