<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        //dd($options);
        $user = $options['user'];

        $builder
            ->add('address', EntityType::class, [
                'label' => 'Choisir ici votre adresse de livraison',
                'class' => Address::class,
                'required' => true,
                'choices'=> $user->getAddresses(),
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('carrier', EntityType::class, [
                'label' => 'Choisir le moyen de livraison',
                'class' => Carrier::class,
                'required' => true,
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Payer',
                'attr'=>[
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => [],
        ]);
    }
}
