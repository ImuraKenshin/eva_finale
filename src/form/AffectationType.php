<?php

namespace App\form;

use App\Entity\Fonction;
use App\Entity\Restaurant;
use App\Entity\Affectation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('restaurant',EntityType::class,[
                'label' => 'Restaurant :',
                'class' => Restaurant::Class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un restaurant',
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir une restaurant.',
                    ]),
                ]
                    ])
            ->add('fonction',EntityType::class,[
                'label' => 'Poste :',
                'class' => Fonction::Class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisir un poste',
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir un poste.',
                    ]),
                ]
                    ])
            ->add('debut', DateType::class,[
                'label' => 'Date de début',
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez choisir une date.',
                    ]),
                ]
            ])
                    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
            'attr' => ['class' => 'custom-form'],
            'csrf_protection' => true,
        ]);
    }
}