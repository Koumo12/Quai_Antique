<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Form\HoraireType;
use App\Repository\HoraireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/horaire', name: 'app_horaire.')]

class HoraireController extends AbstractController
{

    #[Route('/', name: 'horaire')]
    public function index(HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();

        return $this->render('horaire/index.html.twig', [
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/creer', name: 'creer_horaire')]
    public function creer(Request $request, ManagerRegistry $doctrine): Response
    {
        $horaire = new Horaire();

        // Formular
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
             // Entity Manager
            $em = $doctrine->getManager();
            $em->persist($horaire);
            $em->flush();

            return $this->redirect($this->generateUrl('app_horaire.afficher'));
        }
       
        // Response
        return $this->render('horaire/creer.html.twig', [
            'creerForm' => $form->createView()
        ]);
       
    }

    #[Route('/afficher', name: 'afficher')]
    public function afficher(HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();

        return $this->render('horaire/afficher.html.twig', [
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifier($id, Request $request , HoraireRepository $hr, ManagerRegistry $doctrine): Response
    {
        $affHoraire = $hr->findAll($id);
        $horaire = $hr->find($id);

        // Formular
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
             // Entity Manager
            $em = $doctrine->getManager();
            $em->persist($horaire);
            $em->flush();

             // Message
            $this->addFlash('success', 'Horaire a été modifié avec succès!');

            return $this->redirect($this->generateUrl('app_horaire.afficher'));
        }

        
       
        return $this->render('horaire/modifier.html.twig', [
            'creerForm' => $form->createView(),
            'affHoraires' => $affHoraire,
        ]);
    }


    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer($id, HoraireRepository $hr, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $horaire = $hr->find($id);
        $em->remove($horaire);
        $em->flush();

        // Message
        $this->addFlash('success', 'Jour d´ouverture a été supprimé avec succès!');
        
        // Redirect
        return $this->redirect($this->generateUrl('app_horaire.afficher'));
    }
}
