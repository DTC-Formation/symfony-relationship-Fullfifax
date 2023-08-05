<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyle = 'form-control';

        $builder
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Please enter a valid phone number (numbers only).',
                    ]),
                    new Length(['min' => 10, 'max' => 20]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please fill this field',
                    ]),
                    new Email([
                        'message' => 'Please enter an email valid.',
                    ]),
                ],
            ])
            ->add('linkedin', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please fill this field',
                    ]),
                    new Url([
                        'message' => 'Please enter an URL.',
                    ]),
                ],
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
