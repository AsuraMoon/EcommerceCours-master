<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la maison',
                'attr' => [
                    'placeholder' => "Maison Principal"
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Votre Prénom',
                'attr' => [
                    'placeholder' => "Meg"
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre Nom de Famille',
                'attr' => [
                    'placeholder' => "Thomas"
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Votre Sociéte si vous en êtes une',
                'attr' => [
                    'placeholder' => "Microsoft"
                ],
                'required' => false
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre Adresse',
                'attr' => [
                    'placeholder' => "666 avenue des enfers"
                ]
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Votre code postal',
                'attr' => [
                    'placeholder' => "90001"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Votre Ville',
                'attr' => [
                    'placeholder' => "Los Angeles"
                ]
            ])
            ->add('country', CountryType::class, [
                'preferred_choices' => ['US'],
                'label' => 'Votre Pays',
            ])
            ->add('phone', TelType::class, [
                'label' => 'Votre Numéro',
                'attr' => [
                    'placeholder' => "06 07 08 09 10"
                ]
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
