<?php

namespace App\Form;

use App\Entity\Affectation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut', null, ['label'=>'Date début'])
            ->add('date_fin',null, ['label'=>'Date Fin'])
            ->add('user', null, ['label'=>'Utilisateur'])
            ->add('vehicules', null, ['label'=>'Choisir le véhicule'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
