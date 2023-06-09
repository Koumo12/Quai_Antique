<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('price', MoneyType::class , [
                'required' =>  true,
                'label' => 'Prix:'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,

             // enable/disable CSRF protection for this form
             'csrf_protection' => true,
             // the name of the hidden HTML field that stores the token
             'csrf_field_name' => '_token',
             // an arbitrary string used to generate the value of the token
             // using a different string for each form improves its security
             'csrf_token_id'   => 'task_item',
        ]);
    }
}
