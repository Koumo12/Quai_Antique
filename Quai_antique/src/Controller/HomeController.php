<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Repository\GalerieRepository;
use App\Repository\HoraireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index( GalerieRepository $gr, HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();
        $galerie = $gr->findAll();

        return $this->render('home/index.html.twig', [
            'galeries' => $galerie,
            'affHoraires' => $horaire,
        ]);
    }
}
