<?php

namespace App\Form;

use App\Entity\Parcelle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ParcelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('n_parcelle')
            ->add('superficie_parcelle')
            ->add('image', FileType::class, [
                'label' => 'Image du plan du terrain',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '21024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/jpeg',
                            'image/jpeg',
                            'image/png',
                            'image/PNG',
                        ],
                        'mimeTypesMessage' => 'Entrer un bon format d\'image',
                    ])
                ],
            ])
            // ->add('TerrainCadastre')
            // ->add('proprietaireParcelle')
            ->add('Valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parcelle::class,
        ]);
    }
}
