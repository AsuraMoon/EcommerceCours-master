<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'attr' => [
                    'placeholder' => "xxx@xxx.fr"
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
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
