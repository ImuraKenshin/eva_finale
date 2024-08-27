<?php

namespace App\form;

use App\Entity\Fonction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class FonctionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,[
                'label' => 'Nom du poste',
                'attr' => [
                    'class' => 'input_fonction'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom du nouveau poste.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom du poste doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom du poste ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
                    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fonction::class,
            'attr' => ['class' => 'custom-form'],
            'csrf_protection' => true,
        ]);
    }
}