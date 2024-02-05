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
        $livre = $emprunts->getCorrespondre();
        //Check si l'utilisateur a dépassé le nombre d'emprunt
        if (count($adherent->getEmprunts()) >= $maxEmprunts) {
            throw new \Exception("Le nombre total d'emprunt a été atteint, veuillez rendre des livres avant de pouvoir emprunter à nouveau");
        }

        // Check si le livre est empruntable par l'utilisateur
        if (!$livre->isAvailable()) {
            throw new \Exception("Le livre que vous voulez emprunter n'est pas disponible");
        }
    }
}
