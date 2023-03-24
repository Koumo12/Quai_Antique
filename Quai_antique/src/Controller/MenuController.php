<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\HoraireRepository;
use App\Repository\MenuRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu', name: 'app_menu.')]

class MenuController extends AbstractController
{
    #[Route('/', name: 'menu')]
    public function index(MenuRepository $mr, HoraireRepository $hr): Response
    {
        $menu = $mr->findAll();
        $horaire = $hr->findAll();

        
        return $this->render('menu/index.html.twig', [
            'menus' => $menu,
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/creer', name: 'creer_menu')]
    public function creer(Request $request, ManagerRegistry $doctrine, HoraireRepository $hr): Response
    {
        $menu = new Menu();
        $horaire = $hr->findAll();

        // Formular
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
             // Entity Manager
            $em = $doctrine->getManager();
            $em->persist($menu);
            $em->flush();

            return $this->redirect($this->generateUrl('app_menu.afficher'));
        }
       
        // Response
        return $this->render('menu/creer.html.twig', [
            'creerForm' => $form->createView(),
            'affHoraires' => $horaire,
        ]);
       
    }

    #[Route('/afficher', name: 'afficher')]
    public function afficher(MenuRepository $mr, HoraireRepository $hr): Response
    {
        $menu = $mr->findAll();
        $horaire = $hr->findAll();

        return $this->render('menu/afficher.html.twig', [
            'menus' => $menu,
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer($id, MenuRepository $mr, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $menu = $mr->find($id);
        $em->remove($menu);
        $em->flush();

        // Message
        $this->addFlash('success', 'Menu a été supprimé avec succès!');
        
        // Redirect
        return $this->redirect($this->generateUrl('app_menu.afficher'));
    }
}
