<?php

namespace App\Form;

use App\Entity\DemandeEnvoye;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandePCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomDemandePc')
            ->add('nomDemandeAlignement')
            ->add('nomAutreDossier')
            ->add('dateEnvoie')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeEnvoye::class,
        ]);
    }
}
