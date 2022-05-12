<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Place;
use App\Entity\Attachement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Exception\ExceptionInterface;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text')
            ->add('Type')
            ->add('help',ChoiceType::class,[
                'choices'  => [
                    'Yes' => "Yes",
                    'No' => "No",
                ],
                'multiple'=>false,
                'expanded'=>true])
            ->add('qui',ChoiceType::class,[
                'choices'  => [
                    'Police' => "Police",
                    'Civil protection' => "Civil protection",
                    'National guard'=>"National guard",
                    'Other'=>"Other",
                ],
                'multiple'=>false,
                'expanded'=>true])
            ->add('seul',ChoiceType::class,[
                'choices'  => [
                    'Yes' => "Yes",
                    'No' => "No",
                ],
                'multiple'=>false,
                'expanded'=>true])
            ->add('contact')
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
