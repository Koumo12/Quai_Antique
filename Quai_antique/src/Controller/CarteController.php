<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\Category;
use App\Form\CarteType;
use App\Form\CategoryType;
use App\Repository\CarteRepository;
use App\Repository\CategoryRepository;
use App\Repository\HoraireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/carte', name: 'app_carte.')]

class CarteController extends AbstractController
{
    #[Route('/', name: 'carte')]
    public function index(CarteRepository $cr, CategoryRepository $catR, HoraireRepository $hr): Response
    {
        $plat = $cr->findAll();
        $cat = $catR->findAll();
        $horaire = $hr->findAll();

        return $this->render('carte/carte.html.twig', [
            'plats' => $plat,
            'categories' => $cat,
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/creer', name: 'creer_plat')]
    public function creer(Request $request, ManagerRegistry $doctrine, HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();
        $plat = new Carte();

        // Formular
        $form = $this->createForm(CarteType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
             // Entity Manager
            $em = $doctrine->getManager();
            $image = $request->files->get('carte')['image'];

            if($image)
            {
                $dataname = md5(uniqid()). '.'. $image->guessClientExtension();
            }

            $image->move(
                $this->getParameter('images_file'),
                $dataname
            );

            $plat->setImage($dataname);

            // Persist

            $em->persist($plat);
            $em->flush();

            return $this->redirect($this->generateUrl('app_carte.afficher'));
        }
       

        // Response
        return $this->render('Carte/creer.html.twig', [
            'creerForm' => $form->createView(),
            'affHoraires' => $horaire,
        ]);
       
    }

    #[Route('/creer_category', name: 'creer_categorie')]
    public function category(Request $request, ManagerRegistry $doctrine, HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();
        $category = new Category();

        // Formular
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
             // Entity Manager
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('app_carte.afficher_category'));
        }
       

        // Response
        return $this->render('Carte/category.html.twig', [
            'creerForm' => $form->createView(),
            'affHoraires' => $horaire,
        ]);
       
    }

    #[Route('/afficher', name: 'afficher_plat')]
    public function afficher(CarteRepository $cr, HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();
        $plat = $cr->findAll();

        return $this->render('carte/index.html.twig', [
            'plats' => $plat,
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/afficher_category', name: 'afficher_category')]
    public function affCategory(CategoryRepository $cr, HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();
        $cat = $cr->findAll();

        return $this->render('carte/affCategory.html.twig', [
            'cats' => $cat,
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer_plat')]
    public function supprimer($id, CarteRepository $cr, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $plat = $cr->find($id);
        $em->remove($plat);
        $em->flush();

        // Message
        $this->addFlash('success', 'Plat a été supprimé avec succès!');
        
        // Redirect
        return $this->redirect($this->generateUrl('app_carte.afficher'));
    }

    #[Route('/supprim/{id}', name: 'supprimer_category')]
    public function catSupprimer($id, CategoryRepository $cr, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $cat = $cr->find($id);
        $em->remove($cat);
        $em->flush();

        // Message
        $this->addFlash('success', 'Catégorie supprimé avec succès!');
        
        // Redirect
        return $this->redirect($this->generateUrl('app_carte.afficher_category'));
    }
}
