<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyle = 'form-control';

        $builder
            ->add('lot', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ]
            ])
            ->add('cp', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
