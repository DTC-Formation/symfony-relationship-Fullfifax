<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyle = 'form-control my-2 w-50';
        $dateInputStyle = 'form-control my-2 w-25';

        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => $dateInputStyle],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please fill this field',
                    ]),
                ],
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => $dateInputStyle],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'message' => 'Verify the end date',
                        'propertyPath' => 'parent.all[startDate].data',
                    ]),
                ],
            ])
            ->add('post', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
