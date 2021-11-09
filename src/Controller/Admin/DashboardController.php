<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ecommerce');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('Client', 'fas fa-yen-sign', User::class);
        yield MenuItem::section('Mes Catérgories');
        yield MenuItem::linkToCrud('Categories', 'fas fa-cookie', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-list-alt', Product::class);
        yield MenuItem::linkToCrud('Adresse', 'fas fa-map', Address::class);
        yield MenuItem::linkToCrud('Transporteur', 'fas fa-truck', Carrier::class);
    }
}
