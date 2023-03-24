<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('formule', TextType::class , [
                'required' =>  true,
                'label' => 'Formule (ex: Formule de diner)'
            ])
            ->add('wishDay', TextType::class , [
                'required' =>  true,
                'label' => 'Quel jour de la semaine (ex: Du lundi au Samedi midi)'
            ])
            ->add('dishFormule', TextType::class , [
                'required' =>  true,
                'label' => 'Formule du plat (ex: Entrée + plat + dessert)'
            ])
            ->add('price', NumberType::class , [
                'required' =>  true,
                'label' => 'Prix:'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
