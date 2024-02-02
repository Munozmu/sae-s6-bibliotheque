<?php

namespace App\EventListener;

use App\Entity\Adherent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function __invoke(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $adherent = $event->getUser();
        $userData = [];

        if ($adherent instanceof Adherent) {
            $userData['email'] = $adherent->getEmail();
            $userData['nom'] = $adherent->getNom();
            $userData['prenom'] = $adherent->getPrenom();
            $userData['roles'] = $adherent->getRoles();
            $userData['id'] = $adherent->getId();
            $userData['numTel'] = $adherent->getNumTel();
        }

        $data['user'] = $userData;
        $event->setData($data);
    }
}
