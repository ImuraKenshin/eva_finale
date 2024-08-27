<?php

namespace App\form;

use App\Entity\Collaborateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CollaborateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => 'Nom du collaborateur',
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom du nouveau collaborateur.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 180,
                        'minMessage' => 'Le nom du collaborayeur doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom du collaborayeur ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
                    ])
            ->add('prenom',TextType::class,[
                'label' => 'Prenom du collaborateur',
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le prenom du nouveau collaborateur.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le prenom du collaborayeur doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prenom du collaborayeur ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
                    ])
            ->add('mail',EmailType::class,[
                'label' => 'Mail du collaborateur',
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le mail du nouveau collaborateur.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 500,
                        'minMessage' => 'Le mail du collaborayeur doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le mail du collaborayeur ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
                    ])
            ->add('dateEmbauche',DateType::class,[
                'label' => "Date d'embauche",
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez selctionner une date d'embauche pour le nouveau collaborateur.",
                    ]),
                ]
                    ])
                    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collaborateur::class,
            'attr' => ['class' => 'custom-form'],
            'csrf_protection' => true,
        ]);
    }
}