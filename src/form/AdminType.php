<?php

namespace App\form;

use App\Entity\Collaborateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('admin',CheckboxType::class,[
                'label' => 'Etes-vous sûr de vouloir nommer ce collaborateur administrateur?',
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez cocher la case.',
                    ]),
                ]
                    ])
            ->add('password', RepeatedType::class, [
                'label' => false,
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe', 'hash_property_path' => 'password'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe pour le collaborateur.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le prenom du collaborayeur doit contenir au moins {{ limit }} caractères.',
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