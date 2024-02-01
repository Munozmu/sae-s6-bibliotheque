<?php

namespace App\EventListener;

use App\Entity\Livre;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\EventDispatcher\Event;

#[AsEventListener(event: Events::preUpdate, method: 'preUpdate', entity: Livre::class)]
class LivreNotifier
{
    public function preUpdate(Livre $livre, PreUpdateEventArgs $event): void
    {
        $maxCate = 3;

        if (count($livre->getCategories()) >= $maxCate) {
            throw new \Exception("Un livre ne peut pas avoir plus de 3 catégories");
        }
    }
}
