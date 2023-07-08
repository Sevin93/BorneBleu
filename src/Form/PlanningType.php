<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbHeure', ChoiceType::class, [
                'choices' => [
                    '2 heures' => 2,
                    '3 heures' => 3,
                    '4 heures' => 4,
                ],
                'attr' => ["class"=>"form-control"],
                'label' => 'Nombre d\'heures',
                'label_attr' => ["class"=>"form-label"],
                'required' => true,
            ])
            ->add('selectedDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'label' => 'Sélectionnez une date',
                'label_attr' => ["class"=>"form-label"],
                'attr' => ["class"=>"form-control"],
                'required' => true,
            ])
            ->add('selectedSlot', ChoiceType::class, [
                'choices' => [], 
                'label' => 'Sélectionnez un créneau horaire',
                'label_attr' => ["class"=>"form-label"],
                'attr' => ["class"=>"form-control"],
                'required' => true,
                'mapped' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
