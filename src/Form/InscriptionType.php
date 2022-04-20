<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('FullName')
            ->add('Email')
            ->add('Password',PasswordType::class)
            ->add('Gender',ChoiceType::class,[
                'choices'  => [
                    'Male' => "Male",
                    'Female' => "Female",
                ],
                'multiple'=>false,
                'expanded'=>false])
            ->add('Avatar', FileType::class,['required'=>false])
 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
