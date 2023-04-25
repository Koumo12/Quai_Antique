<?php

namespace App\Controller;

use App\Entity\InfoTable;
use App\Form\InfoTableType;
use App\Repository\HoraireRepository;
use App\Repository\InfoTableRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/table', name: 'app_res_table.')]

class ResTableController extends AbstractController
{
    #[Route('/', name: 'table_list')]
    public function index(InfoTableRepository $ir, HoraireRepository $hr): Response
    {
        return $this->render('res_table/index.html.twig', [
            'infoTable' =>$ir->findAll(),
            'affHoraires' => $hr->findAll(),
        ]);
    }

    #[Route('/creer', name: 'resTable')]
    public function creer(Request $request, ManagerRegistry $doctrine, HoraireRepository $hr): Response
    {
        $table = new InfoTable();
        $form = $this->createForm(InfoTableType::class, $table)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            
            $em = $doctrine->getManager();
            $em->persist($table);
            $em->flush();

            return $this->redirectToRoute('app_res_table.table_list');
        }

        return $this->render('res_table/creer.html.twig', [
            'form' =>$form->createView(),
            'affHoraires' => $hr->findAll(),
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifier($id, Request $request, ManagerRegistry $doctrine, InfoTableRepository $ir, HoraireRepository $hr): Response
    {
        $horaire = $hr->findAll();
        $inf = $ir->find($id);

        $form = $this->createForm(InfoTableType::class, $inf)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->flush();

            return $this->redirectToRoute('app_res_table.table_list');
        }

        return $this->render('res_table/modifier.html.twig', [
            "form" => $form->createView(),
            'affHoraires' => $horaire,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer($id, ManagerRegistry $doctrine, InfoTableRepository $ir): Response
    {
      
        $em = $doctrine->getManager();
        $info = $ir->find($id);
        $em->remove($info);
        $em->flush();

        // Message
        $this->addFlash('success', 'Info table a été supprimé avec succès!');
        
        // Redirect
        return $this->redirect($this->generateUrl('app_res_table.table_list'));
    }
}
