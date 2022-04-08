<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FullName')
            ->add('Email')
            ->add('Password')
            ->add('Gender')
            ->add('Nationalite')
            ->add('Role')
            ->add('CreatedAt')
            ->add('HasPlaces')
            ->add('IsPartner')
            ->add('Balance')
            ->add('Avatar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
