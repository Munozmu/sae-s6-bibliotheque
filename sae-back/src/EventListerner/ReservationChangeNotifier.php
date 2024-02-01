<?php

namespace App\EventListener;

use App\Entity\Reservations;
use Doctrine\ORM\Events;
use Doctine\ORM\Events\PrePersistEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs as EventPrePersistEventArgs;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: Events::prePersist, method: 'prePersist', entity: Reservations::class)]
class ReservationNotifier
{
    public function prePersist(Reservations $resa, EventPrePersistEventArgs $event): void
    {
        $maxResa = 3;
        $adherent = $resa->getReserverPar();
        if (count($adherent->getReservations()) >= $maxResa) {
            throw new \Exception("Le nombre total de reservation a éte atteint");
        }
    }
}
