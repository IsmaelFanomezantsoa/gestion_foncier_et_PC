<?php

namespace App\Form;

use App\Entity\Contenance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('usageBatimentContenance')
            ->add('surfaceOccupeContenance')
            // ->add('nbContenance')
            // ->add('terrainTitre')
            // ->add('terrainCf')
            // ->add('parcelle')
            ->add('Valider', SubmitType::class )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contenance::class,
        ]);
    }
}
