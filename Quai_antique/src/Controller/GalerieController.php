<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Repository\GalerieRepository;
use App\Repository\HoraireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/galerie', name: 'app_galerie.')]

class GalerieController extends AbstractController
{
    #[Route('/', name: 'modifier')]
    public function index(GalerieRepository $gr, HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();
        $galerie = $gr->findAll();

        return $this->render('galerie/index.html.twig', [
            'galerie' => $galerie,
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/creer', name: 'creer_galerie')]
    public function creer(Request $request, ManagerRegistry $doctrine, HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();
        $galerie = new Galerie();

        // Formular
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
             // Entity Manager
            $em = $doctrine->getManager();
            $image = $request->files->get('galerie')['image'];

            if($image)
            {
                $dataname = md5(uniqid()). '.'. $image->guessClientExtension();
            }

            $image->move(
                $this->getParameter('images_file'),
                $dataname
            );

            $galerie->setImage($dataname);

            // Persist

            $em->persist($galerie);
            $em->flush();

            return $this->redirect($this->generateUrl('app_galerie.modifier'));
        }
       

        // Response
        return $this->render('galerie/creer.html.twig', [
            'creerForm' => $form->createView(),
            'affHoraires' => $horaire,
        ]);
       
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer($id, GalerieRepository $gr, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $galerie = $gr->find($id);
        $em->remove($galerie);
        $em->flush();

        // Message
        $this->addFlash('success', 'Plat a été supprimé avec succès!');
        
        // Redirect
        return $this->redirect($this->generateUrl('app_galerie.modifier'));
    }
}
