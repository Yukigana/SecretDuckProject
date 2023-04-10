<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',
                TextType::class,
            [
                'label' => 'Nom du produit',
                'invalid_message' => 'Le nom est trop long',
            ])
            ->add('prix',
            NumberType::class,
            [
                'label' => 'Prix',
                'invalid_message' => 'Le prix n\'est pas un nombre',
            ])
            ->add('quantite',
            NumberType::class,
            [
                'label' => 'Quantité',
                'invalid_message' => 'La quantité n\'est pas un nombre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
