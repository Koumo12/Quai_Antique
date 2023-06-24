<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\HoraireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, HoraireRepository $hr,  UserPasswordHasherInterface $passHasher,ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $horaire = $hr->findAll();

         
        $inscription = $this->createFormBuilder()
        ->add('email', EmailType::class, [
            'label' => 'Email'
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' =>  true,
            'first_options' => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmer votre mot de passe'] 
        ])
        ->add('Enregistrer', SubmitType::class)
        ->getForm()
        ;

        $inscription->handleRequest($request);

        if($inscription->isSubmitted())
        {
            $infoSaisi = $inscription->getData();

            $user = new  User();
            $user->setEmail($infoSaisi['email']);

            $user->setPassword(
                $passHasher->hashPassword($user, $infoSaisi['password'])
            );

            $user->setRawPassword( $infoSaisi['password']);

            /* uniquement pour créer un admin */
            $role = ['ROLE_ADMIN'];
            $user->setRoles($role);

                $errors = $validator->validate($user);
                if(count($errors) > 0)
                {
                    return $this->render('inscription/index.html.twig', [
                        'inscription' => $inscription->createView(),
                        'errors' => $errors,
                        'affHoraires' => $horaire,
                    ]);
                } else {
                    $em = $doctrine->getManager();
                    $em->persist($user);
                    $em->flush();
                }

            // Message
            $this->addFlash('success', 'Votre compte administrateur a été créer avec succès!');

            return $this->redirect($this->generateUrl('app_inscription'));
        }

        return $this->render('inscription/index.html.twig', [            
            'affHoraires' => $horaire,
            'inscription' => $inscription->createView(),
            'errors' => null,
        ]);
    }
}
