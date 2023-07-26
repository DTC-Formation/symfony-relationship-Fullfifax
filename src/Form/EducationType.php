<?php

namespace App\Form;

use App\Entity\Education;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyle = 'form-control my-2 w-50';
        $dateInputStyle = 'form-control my-2 w-25';

        $builder
            ->add('diploma', TextType::class, [
                'attr' => ['class' => $inputStyle],
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => $dateInputStyle],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Education::class,
        ]);
    }
}
