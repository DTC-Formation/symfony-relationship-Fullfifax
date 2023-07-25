<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyle = 'form-control';

        $builder
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ]
            ])
            ->add('linkedin', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
