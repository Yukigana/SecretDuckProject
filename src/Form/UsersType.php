<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login',
                TextType::class,
                [
                    'label' => 'Nom du produit',
                    'invalid_message' => 'Le login est trop long',
                ])
            ->add('mdp',
                TextType::class,
                [
                    'label' => 'Nom du produit',
                    'invalid_message' => 'La longueur n\'est pas valide',
                ])
            ->add('nom',
                TextType::class,
                [
                    'label' => 'Nom du produit',
                    'invalid_message' => 'Le nom est trop long',
                ])
            ->add('prenom',
                TextType::class,
                [
                    'label' => 'Nom du produit',
                    'invalid_message' => 'Le prenom est trop long',
                ])
            ->add('dateNaissance')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
