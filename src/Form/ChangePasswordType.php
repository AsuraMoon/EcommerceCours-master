<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, [
                'disabled' => true,
            ])

            ->add('firstName', null, [
                'disabled' => true,
            ])

            ->add('lastName', null, [
                'disabled' => true,
            ])

            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Mot de Passe Actuel', 
                ]
            ])

            ->add('new_password', RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les mots de passe ne sont pas identiques',
                'options'=>[
                    'attr' => [
                        'class'=> 'password-field',
                    ],
                ],
                'required'=>'true',
                'first_options' => [
                    'label' => 'Votre Mot de passe',
                    'attr' => [
                        'placeholder' => 'Mot de passe'
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer Votre Mot de passe',
                    'attr' => [
                        'placeholder' => 'Veuillez confirmer votre Mot de passe'
                    ],
                ],
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
