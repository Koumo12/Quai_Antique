<?php

namespace App\Controller;

use App\Entity\InfoTable;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\HoraireRepository;
use App\Repository\InfoTableRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ReservationController extends AbstractController
{
    

    public function __construct(private Security $security) 
    {
       
    }

    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    #[Route('/reserver', name: 'reservation', methods:['GET','POST'])]
    public function creer(Request $request, ManagerRegistry $doctrine, HoraireRepository $hr, Security $security ): Response
    {   
        $reservation = new Reservation(); 

        if($this->security->isGranted('ROLE_USER'))
        {  
            $user = $security->getUser();
            $nc = $user->getNbreConvive();
            $al = $user->isAllergie();
            

            $form = $this->createFormBuilder()
                ->add('name', TextType::class)
                ->add('nbreConvive', NumberType::class, [
                    'label' => 'Nombre de couverts',
                    'data' => $nc,
                ])
                ->add('date', DateType::class, [
                    'label' => 'Date',
                    'html5' => false,
                    'input' => 'datetime_immutable',
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy', 
                    'constraints' => [
                        new GreaterThanOrEqual([
                            'value' => 'now', 
                            'message' => 'La date doit être ultérieure ou égale à la date actuelle.'
                        ]),                
                    ],     
                ])        
                ->add('allergie', ChoiceType::class, [
                    'required' => false,                  
                    'label' => 'Avez-vous des allergies ?',
                    'choices' =>  [
                        'oui' => true,
                        'non' => false
                    ],
                    'data' => $al,
                    'expanded' => true,
                    'multiple' => false,
                ])  
                ->add('subgroup', ChoiceType::class, [
                        'label' => 'Midi',
                        'choices' => [
                            '12:00' => '12:00',
                            '12:15' => '12:15',
                            '12:30' => '12:30',
                            '12:45' => '12:45',
                            '13:00' => '13:00',
                            '13:15' => '13:15',
                            '13:30' => '13:30',
                            '13:45' => '13:45',
                            '14:00' => '14:00',
                        ], 
                        'expanded' => true,
                        'multiple' => true,
                    ])   
                ->add('subgroup2', ChoiceType::class, [
                    'label' => 'Soir',
                    'choices' => [
                        '19:00' => '19:00',
                        '19:15' => '19:15',
                        '19:30' => '19:30',
                        '19:45' => '19:45',
                        '20:00' => '20:00',
                        '20:15' => '20:15',
                        '20:30' => '20:30',
                        '20:45' => '20:45',
                        '21:00' => '21:00',
                    ], 
                    'expanded' => true,
                    'multiple' => true,
                ]) 
                ->add('comment', TextareaType::class, [
                    'label' => 'Autres précisions',
                    'help' => 'Ex: Nombre d´enfants présent'
                ])             
                ->getForm()
            ;

                       
            $form->handleRequest($request);

          
            if($form->isSubmitted() && $form->isValid())
            {
                $infoSaisi = $form->getData();

                $reservation->setName($infoSaisi['name']);
                $reservation->setNbreConvive($infoSaisi['nbreConvive']);                
                $reservation->setDate($infoSaisi['date']);
                $reservation->setSubgroup($infoSaisi['subgroup']);
                $reservation->setSubgroup2($infoSaisi['subgroup2']);
                $reservation->setComment($infoSaisi['comment']);
                $reservation->setAllergie($infoSaisi['allergie']);
                
                // Enrégistrer les données dans la table Réservation
                $em = $doctrine->getManager();
                $em->persist($reservation);
                $em->flush();
    
                // Message
                $this->addFlash('success', 'Votre table a été reservé avec succès!');
    
                return new RedirectResponse('/reserver');
            }           

        } else 
        {            
            $form = $this->createFormBuilder()
                ->add('name', TextType::class)
                ->add('nbreConvive', NumberType::class, [
                    'label' => 'Nombre de couverts',
                ])
                ->add('date', DateType::class, [
                    'label' => 'Date',
                    'html5' => false,
                    'input' => 'datetime_immutable',
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy', 
                    'constraints' => [
                        new GreaterThanOrEqual([
                            'value' => 'now', 
                            'message' => 'La date doit être ultérieure ou égale à la date actuelle.'
                        ]),                
                    ],     
                ])        
                ->add('allergie', ChoiceType::class, [
                    'required' => false,                  
                    'label' => 'Avez-vous des allergies ?',
                    'choices' =>  [
                        'oui' => true,
                        'non' => false
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ])  
                ->add('subgroup', ChoiceType::class, [
                        'label' => 'Midi',
                        'choices' => [
                            '12:00' => '12:00',
                            '12:15' => '12:15',
                            '12:30' => '12:30',
                            '12:45' => '12:45',
                            '13:00' => '13:00',
                            '13:15' => '13:15',
                            '13:30' => '13:30',
                            '13:45' => '13:45',
                            '14:00' => '14:00',
                        ], 
                        'expanded' => true,
                        'multiple' => true,
                    ])   
                ->add('subgroup2', ChoiceType::class, [
                    'label' => 'Soir',
                    'choices' => [
                        '19:00' => '19:00',
                        '19:15' => '19:15',
                        '19:30' => '19:30',
                        '19:45' => '19:45',
                        '20:00' => '20:00',
                        '20:15' => '20:15',
                        '20:30' => '20:30',
                        '20:45' => '20:45',
                        '21:00' => '21:00',
                    ], 
                    'expanded' => true,
                    'multiple' => true,
                ]) 
                ->add('comment', TextareaType::class, [
                    'label' => 'Autres précisions',
                    'help' => 'Ex: Nombre d´enfants présent'
                ])             
                ->getForm()
            ;
         
       
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid())
            {
                $infoSaisi = $form->getData();

                $reservation->setName($infoSaisi['name']); 
                $reservation->setNbreConvive($infoSaisi['nbreConvive']);                               
                $reservation->setDate($infoSaisi['date']);
                $reservation->setSubgroup($infoSaisi['subgroup']);
                $reservation->setSubgroup2($infoSaisi['subgroup2']);
                $reservation->setComment($infoSaisi['comment']);
                $reservation->setAllergie($infoSaisi['allergie']);
            
                
                $em = $doctrine->getManager();
                $em->persist($reservation);
                $em->flush();
    
                // Message
                $this->addFlash('success', 'Votre table a été reservé avec succès!');
    
                return new RedirectResponse('/reserver');
            }
            
        }

        return $this->render('reservation/creer.html.twig', [
            'form' =>$form->createView(),
            'affHoraires' => $hr->findAll(),
        ]);
    }  

    #[Route('/traitement', name: 'traitement')]
    public function traitement(ManagerRegistry $doctrine, InfoTableRepository $it, ): Response
    {

        $en = $doctrine->getManager();
        $query1 = $en->createQuery(
            'SELECT SUM(r.nbreConvive)
                FROM App\Entity\Reservation r
                '
        );

        $query1 = $query1->getResult();
       
        $query2 = $en->createQuery(
            'SELECT i.placeNumber
                FROM App\Entity\InfoTable i
                '
        );

        $query2 = $query2->getResult();
       
        $query = array_merge($query1, $query2);

        return new JsonResponse($query);
    }    
    
}
