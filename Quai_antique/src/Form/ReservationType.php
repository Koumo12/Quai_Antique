<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ReservationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('nbreConvive', NumberType::class, [
                'label' => 'Nombre de couverts'
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
        ;
       
      
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
