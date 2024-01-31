<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adherent;
use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Reservations;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle(' Bibliothèque');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('gestion');
        yield MenuItem::linkToCrud('Emprunt', 'fas fa-text', Emprunt::class);
        yield MenuItem::linkToCrud('Reservations', 'fas fa-text', Reservations::class);
        yield MenuItem::linkToCrud('Adherent', 'fas fa-text', Adherent::class);
        yield MenuItem::section('catalogue');
        yield MenuItem::linkToCrud('Auteur', 'fas fa-text', Auteur::class);
        yield MenuItem::linkToCrud('Categorie', 'fas fa-text', Categorie::class);
        yield MenuItem::linkToCrud('Livre', 'fas fa-text', Livre::class);
    }
}
