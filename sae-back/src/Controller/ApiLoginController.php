<?php

namespace App\Controller;

use App\Entity\Adherent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_api_login')]
    public function index(#[CurrentUser] ?Adherent $adherent): Response
    {
        if (null === $adherent) {
            return $this->json([
                'message' => 'inconnu au bataillon',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'user' => $adherent->getEmail(),
        ]);
    }
}
