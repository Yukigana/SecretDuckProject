<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Date;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('login',
                TextType::class,
                [
                    'label' => 'Login : ',
                    'invalid_message' => 'Le nom est trop long',
                ])
            ->add('nom',
                TextType::class,
                [
                    'label' => 'Nom : ',
                    'invalid_message' => 'Le nom est trop long',
                ])
            ->add('prenom',
                TextType::class,
                [
                    'label' => 'Prenom : ',
                    'invalid_message' => 'Le prenom est trop long',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
