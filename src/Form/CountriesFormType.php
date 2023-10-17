<?php

namespace App\Form;

use App\Entity\Countries;
use Symfony\Component\Intl\Countries as pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CountriesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('country', ChoiceType::class, [
            "choices" => array_flip(pays::getNames('fr')),
            'placeholder' => 'Choisissez un pays',
            "data_class" => null,
        ])
        ->add('imageFile', VichImageType::class)
        ->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'delete_label' => 'Supprimer l\'image',
            'download_label' => false,
            'download_uri' => false,
            'image_uri' => false,
            'imagine_pattern' => false,
            'asset_helper' => true,
        ])
            ->add('description', TextareaType::class)
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Countries::class,
        ]);
    }
}
