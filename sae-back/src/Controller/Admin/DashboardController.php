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
use App\Repository\AdherentRepository;
use App\Repository\CategorieRepository;
use App\Repository\EmpruntRepository;
use App\Repository\LivreRepository;
use App\Repository\ReservationsRepository;

class DashboardController extends AbstractDashboardController
{
    protected $adherentRepository;
    protected $auteurRepository;
    protected $categorieRepository;
    protected $empruntRepository;
    protected $livreRepository;
    protected $reservationsRepository;

    public function __construct(
        AdherentRepository $adherentRepository,
        // AuteurRepository $auteurRepository,
        // CategorieRepository $categorieRepository,
        EmpruntRepository $empruntRepository,
        LivreRepository $livreRepository,
        // ReservationsRepository $reservationsRepository,
    )
    {
        $this->adherentRepository = $adherentRepository;
        // $this->auteurRepository = $auteurRepository;
        // $this->categorieRepository = $categorieRepository;
        $this->empruntRepository = $empruntRepository;
        $this->livreRepository = $livreRepository;
        // $this->reservationsRepository = $reservationsRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/emprunts.html.twig', [
            'AllAdherents' => $this->adherentRepository->findAll(),
            'LivresEmprunts' => $this->empruntRepository->getAllEmprunts(),
        ]);
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle(' Bibliothèque');
    }

    public function configureLivres(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Livres');
    }

    #[Route('/admin/livre', name: 'livre_history')]
    public function livreHistory(): Response
    {
        return $this->render('admin/history.html.twig', [
            'livres' => $this->livreRepository->getAllLivresWithEmprunts(),
        ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('gestion');
        yield MenuItem::linkToRoute('Historique','fas fa-history', 'livre_history');
        yield MenuItem::linkToCrud('Emprunt', 'fas fa-text', Emprunt::class);
        // yield MenuItem::linkToRoute('Tableau de Bord', 'fas fa-chart-bar', 'emprunts');
        // yield MenuItem::linkToCrud('Reservations', 'fas fa-text', Reservations::class);
        yield MenuItem::linkToCrud('Adherent', 'fas fa-text', Adherent::class);
        yield MenuItem::section('catalogue');
        yield MenuItem::linkToCrud('Auteur', 'fas fa-text', Auteur::class);
        yield MenuItem::linkToCrud('Categorie', 'fas fa-text', Categorie::class);
        yield MenuItem::linkToCrud('Livre', 'fas fa-text', Livre::class);
    }
}
