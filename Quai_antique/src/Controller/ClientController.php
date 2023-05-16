<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\HoraireRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, HoraireRepository $hr): Response
    {
        return $this->render('client/index.html.twig', [
            'users' => $userRepository->findAll(),
            'affHoraires' => $hr->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  HoraireRepository $hr,  UserPasswordHasherInterface $passHasher,ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $user = new User();
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'required' =>  true,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' =>  true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer votre mot de passe'] 
            ])
            ->add('nbreConvive', NumberType::class, [
                'required' => false,
                'label' => 'Nombres de convives ',
            ])
            ->add('allergie', ChoiceType::class, [
                'required' => false,
                'label' => 'Avez-vous des allergies ?',
                'choices' =>  [
                    'oui' => true,
                    'non' => false
                ]
            ])           
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $infoSaisi = $form->getData();

           
            $user->setEmail($infoSaisi['email']);

            $user->setPassword(
                $passHasher->hashPassword($user, $infoSaisi['password'])
            );

            $user->setRawPassword( $infoSaisi['password']);

            /* uniquement pour créer un admin */
            $role = ['ROLE_USER'];
            $user->setRoles($role);
            $user->setNbreConvive($infoSaisi['nbreConvive']);
            $user->setAllergie($infoSaisi['allergie']);

                $errors = $validator->validate($user);
                if(count($errors) > 0)
                {
                    return $this->render('client/new.html.twig', [
                        'creerform' => $form->createView(),
                        'errors' => $errors,
                        'affHoraires' => $hr->findAll(),
                    ]);
                } else {
                    $em = $doctrine->getManager();
                    $em->persist($user);
                    $em->flush();
                }

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'user' => $user,
            'errors' => null,
            'creerform' => $form,
            'affHoraires' => $hr->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(User $user, HoraireRepository $hr): Response
    {
        return $this->render('client/show.html.twig', [
            'user' => $user,
            'affHoraires' => $hr->findAll(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, HoraireRepository $hr): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'user' => $user,
            'creerform' => $form,
            'affHoraires' => $hr->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
