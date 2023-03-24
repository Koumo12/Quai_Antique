<?php

namespace App\Form;

use App\Entity\Horaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day', TextType::class , [
                'required' => true,
            ])
            ->add('MStartTime', TimeType::class , [
                'label' => 'Midi Heure d´ouverture',
            ])
            ->add('MEndTime', TimeType::class , [
                'label' => 'Fermeture',
            ])
            ->add('SStartTime', TimeType::class , [
                'label' => 'Soir Heure d´ouverture',
            ])
            ->add('SEndTime', TimeType::class , [
                'label' => 'Fermeture',
            ])
            ->add('isOpen', ChoiceType::class , [
                'required' => true,
                'label' => 'Ouvert ou Fermée',
                'choices' => [
                    'Ouvert' => true,
                    'Fermé' => false,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaire::class,
        ]);
    }


}
