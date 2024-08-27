<?php

namespace App\form;

use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => 'Nom du restaurant',
                'attr' => [
                    'class' => 'input_restaurant'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom du nouveau restaurant.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom du restaurant doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom du restaurant ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
                    ])
            ->add('adresse',TextType::class,[
                'label' => 'Adresse du restaurant',
                'attr' => [
                    'class' => 'input_restaurant'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez saisir l'adresse du nouveau restaurant.",
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 500,
                        'minMessage' => "l'adresse du restaurant doit contenir au moins {{ limit }} caractères.",
                        'maxMessage' => "l'adresse du restaurant ne peut pas dépasser {{ limit }} caractères.",
                    ]),
                ]
                ])
            ->add('codePostal',TextType::class,[
                'label' => 'Code postal',
                'attr' => [
                    'class' => 'input_restaurant'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le code postal du nouveau restaurant.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 6,
                        'minMessage' => 'le code postal doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'le code postal ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
                ])
            ->add('ville',TextType::class,[
                'label' => 'Ville',
                'attr' => [
                    'class' => 'input_restaurant'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir la ville où se situe le nouveau restaurant.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 500,
                        'minMessage' => 'Le nom de la ville doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom de la ville ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
                ])
            ->add('etat', CheckboxType::class, [
                    'label' => false,
                    'attr' => [
                        'style' => 'display:none;',
                    ],
                    'data' => true,
                    'required' => false,
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
            'attr' => ['class' => 'custom-form'],
            'csrf_protection' => true,
        ]);
    }
}