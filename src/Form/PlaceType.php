<?php

namespace App\Form;

use App\Entity\Place;
use App\Entity\Category;
use App\Entity\Attachement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Description')
            ->add('Adress')
            ->add('City')
            ->add('PostalCode')
            ->add('Latitude')
            ->add('Longitude')
            ->add('Type', ChoiceType::class,[
                'choices'  => [
                    'Public' => "Public",
                    'Private' => "Private",
                ],
                'multiple'=>false,
                'expanded'=>false])
            ->add('Category',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'Name'
            ]);
        //  ->add('Attachement', FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
        ]);
    }
}
