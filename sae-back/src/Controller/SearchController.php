<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('api/search', name: 'app_search')]
    public function index(Request $request, LivreRepository $livreRepo): Response
    {
        $keywords = $request->query->get('keywords');
        $category = $request->query->get('category');
        $author = $request->query->get('author');
        $lang = $request->query->get('lang');
        $anneeMin = $request->query->get('anneeMin');
        $anneeMax = $request->query->get('anneeMax');

        $data = $livreRepo->searchByParameter($keywords, $lang, $anneeMin, $anneeMax, $author, $category);

        return $this->json($data);
    }
}
