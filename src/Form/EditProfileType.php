<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use App\Form\AttachementType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('FullName', TextType::class)
            ->add('Nationalite', ChoiceType::class,[
                'choices'  => [
                    'TN' => "TN",
                    'FR' => "FR",
                ],
                'multiple'=>false,
                'expanded'=>false])            
                ->add('Gender', ChoiceType::class,[
                'choices'  => [
                    'Male' => "Male",
                    'Female' => "Female",
                ],
                'multiple'=>false,
                'expanded'=>false])
                ->add('Avatar', AttachementType::class)
                ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
