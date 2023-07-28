<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyle = 'form-control';

        $builder
            ->add('lot', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Fill this field'
                    ]),
                    new Length(['max' => 255]),
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Fill this field',
                    ]),
                    new Length(['max' => 255]),
                ],
            ])
            ->add('cp', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Fill this field',
                    ]),
                    new Length([
                        'max' => 255,
                    ]),
                ],
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
