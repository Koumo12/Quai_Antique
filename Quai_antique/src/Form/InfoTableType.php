<?php

namespace App\Form;

use App\Entity\InfoTable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('placeNumber', NumberType::class, [
                'required' =>  false,
                'label' => 'Nombre de places',
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfoTable::class,

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
