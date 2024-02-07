<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Repository\AdherentRepository;
use App\Repository\ReservationsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('api/reservation/user/{userId} ', name: 'app_reservation_reservation_user')]
    public function getReservationsUser(string $userId, AdherentRepository $adherentRepo): Response
    {
        $adherent = $adherentRepo->findOneBy(["id" => $userId]);

        $reservationData = [];

        foreach ($adherent->getReservations() as $reservation) {
            $reservationData[[
                'id' => $reservation->getId(),
                'dateResa' => $reservation->getDateResa(),
                'book' => []
            ]];

            foreach ($reservation->getLier() as $livre) {
                $bookData = json_encode($livre);
            }

            $reservationData['book'][] = $bookData;
        }

        return $this->json($reservationData);
    }
}
