<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' =>  true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer votre mot de passe'] 
            ])
            ->add('nbreConvive', NumberType::class, [
                    'label' => 'Nombres de convives?',
                
                ])
            ->add('allergie', ChoiceType::class, [
                'label' => 'Avez-vous des allergies?',
                'choices' =>  [
                    'oui' => true,
                    'non' => false
                ],
                'expanded' => true,
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,

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
