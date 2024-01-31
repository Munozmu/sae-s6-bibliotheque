<?php

namespace App\EventListener;

use App\Entity\Emprunt;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Emprunt::class)]
class EmpruntNotifier
{

    public function prePersist(Emprunt $emprunts, PrePersistEventArgs $event): void
    {

        $maxEmprunts = 3;
        $adherent = $emprunts->getAdherent();
        if (count($adherent->getEmprunts()) >= $maxEmprunts) {
            throw new \Exception("Le nombre total d'emprunt a été atteint, veuillez rendre des livres avant de pouvoir emprunter à nouveau");
        }
    }
}
