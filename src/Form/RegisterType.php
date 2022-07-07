<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => new Length(null, 2, 30), //on place une contrainte sur le nombre mot que l'utilisateur peut mettre //
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom']
                
                ]) //input formulaire d'enregistrement

            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => new Length(null, 2, 30), //on place une contrainte sur le nombre mot que l'utilisateur peut mettre //
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom']
            ]) //input formulaire d'enregistrement

            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'constraints' => new Length(null, 2, 50), //on place une contrainte sur le nombre mot que l'utilisateur peut mettre //
                'attr' => [
                    'placeholder' => 'Merci de saisir votre Email'
                ]

            ]) //input formulaire d'enregistrement
            
            ->add('password', RepeatedType::class, [ // cette fonction permet de mettre en place l'input mot de passe et confirmer mot de passe //
                'type' => PasswordType::class,
                'invalid_message' => 'les mots de passes doivent être identique',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmer votre mot de passe'
                    ]
                ],               
                
            ]) //input

            


            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
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
