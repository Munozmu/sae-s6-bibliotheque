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
use DateTime;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand;

use Symfony\Component\HttpFoundation\Request;

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
    ) {
        $this->adherentRepository = $adherentRepository;
        // $this->auteurRepository = $auteurRepository;
        // $this->categorieRepository = $categorieRepository;
        $this->empruntRepository = $empruntRepository;
        $this->livreRepository = $livreRepository;
        $this->livreRepository = $livreRepository;

        // $this->reservationsRepository = $reservationsRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/emprunts.html.twig', [
            'AllAdherents' => $this->adherentRepository->findAll(),
            'LivresEmprunts' => $this->empruntRepository->getActualEmprunts(),
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
            'count' => $this->livreRepository->countAllEmprunts(),
        ]);
    }

    #[Route('/admin/retour', name: 'retour_emprunt')]
    public function retourEmprunt(Request $request): Response
    {
        $empruntId = $request->query->get('empruntId');
        $emprunt = null;
        // Si l'ID de l'emprunt est disponible, récupérer l'emprunt correspondant
        if ($empruntId) {
            $emprunt = $this->empruntRepository->find($empruntId);
        }
        if ($emprunt) {
            $this->empruntRepository->retourEmprunt($emprunt);
        }
        return $this->render('admin/retour.html.twig', [
            'AllAdherents' => $this->adherentRepository->findAll(),
            'LivresEmprunts' => $this->empruntRepository->getActualEmprunts(),
        ]);
    }


    #[Route('/admin/formulaire', name: 'formulaire_emprunt')]
public function formulaire(Request $request): Response
{
    try {
        $adherentId = $request->query->get('adherentId');
        $livreId1 = $request->query->get('livreId1');
        $livreId2 = $request->query->get('livreId2');
        $livreId3 = $request->query->get('livreId3');
        $livreId4 = $request->query->get('livreId4');
        $livreId5 = $request->query->get('livreId5');
        // $dateEmprunt = null;
        // $dateRetour = null;
        $emprunteurs = [];
        $allAdherents = $this->adherentRepository->findAll();
        $dateEmprunt = new DateTime($request->query->get('dateEmprunt'));
        $dateRetour = new DateTime($request->query->get('dateRetour'));
        $adherent = null;
        $livre1 = null;
        $livre2 = null;
        $livre3 = null;
        $livre4 = null;
        $livre5 = null;
        foreach ($allAdherents as $adherent) {
            if ($this->adherentRepository->peutEmprunter($adherent)) {
                // Si l'adhérent peut emprunter, ajoutez-le au tableau $emprunteurs
                $emprunteurs[] = $adherent;
            }
        }
        if ($livreId1) {
            $livre1 = $this->livreRepository->find($livreId1);
        }
        if ($livreId2) {
            $livre2 = $this->livreRepository->find($livreId2);
        }
        if ($livreId3) {
            $livre3 = $this->livreRepository->find($livreId3);
        }
        if ($livreId4) {
            $livre2 = $this->livreRepository->find($livreId4);
        }
        if ($livreId5) {
            $livre3 = $this->livreRepository->find($livreId5);
        }
        if ($adherentId) {
            $adherent = $this->adherentRepository->find($adherentId);
        }
        if ($adherent && $livre1 && $dateEmprunt && $dateRetour ) {
            $this->empruntRepository->makeEmprunt($adherent, $livre1, $dateEmprunt, $dateRetour);
        }
        if ($adherent && $livre2 && $dateEmprunt && $dateRetour ) {
            $this->empruntRepository->makeEmprunt($adherent, $livre2, $dateEmprunt, $dateRetour);
        }
        if ($adherent && $livre3 && $dateEmprunt && $dateRetour ) {
            $this->empruntRepository->makeEmprunt($adherent, $livre3, $dateEmprunt, $dateRetour);
        }
        return $this->render('admin/formulaire.html.twig', [
            'Adherents' => $emprunteurs,
            'LivresEmpruntes' => $this->empruntRepository->getLivresNonDisponiblesAvecDateRetour(),
            'LivresNonEmpruntes' => $this->livreRepository->getLivresNonEmpruntes(),
            // 'NbEmprunts' => $this->adherentRepository->nbEmprunt(),
            
        ]);
    } catch (\Exception $e) {
        // Gérer l'exception ici, par exemple en renvoyant une réponse avec un message d'erreur
        return $this->render('admin/password.html.twig', [
            'Reponse' => "Une erreur est survenue : Le nombre total d'emprunt a été atteint, veuillez rendre des livres avant de pouvoir emprunter à nouveau",
        ]);
    }
}

    


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('gestion');
        yield MenuItem::linkToRoute('Historique','fas fa-history', 'livre_history');
        yield MenuItem::linkToCrud('Emprunt', 'fas fa-text', Emprunt::class);
        yield MenuItem::linkToCrud('Réservations', 'fas fa-text', Reservations::class);
        yield MenuItem::linkToRoute('Formulaire','fas fa-text', 'formulaire_emprunt');
        yield MenuItem::linkToRoute('Retour','fas fa-text', 'retour_emprunt');
        // yield MenuItem::linkToRoute('Tableau de Bord', 'fas fa-chart-bar', 'emprunts');
        // yield MenuItem::linkToCrud('Reservations', 'fas fa-text', Reservations::class);
        yield MenuItem::linkToCrud('Adherent', 'fas fa-text', Adherent::class);
        yield MenuItem::section('catalogue');
        yield MenuItem::linkToCrud('Auteur', 'fas fa-text', Auteur::class);
        yield MenuItem::linkToCrud('Categorie', 'fas fa-text', Categorie::class);
        yield MenuItem::linkToCrud('Livre', 'fas fa-text', Livre::class);
    }
}
