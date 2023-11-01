<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class EditProfilePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'mapped'     => false,
                'constraints' => [
                    new UserPassword([
                        "message" => "Cet champ doit être remplie avec votre mot de pass actuel"
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le nouveau mot de passe est obligatoire',
                        ]),
                        new Length([
                            'min' => 12,
                            'minMessage' => 'Le nouveau mot de passe doit contenir au minimum {{ limit }} caractèrs',
                            // max length allowed by Symfony for security reasons
                            'max' => 255,
                            'maxMessage' => 'Le nouveau mot de passe doit contenir au maximum {{ limit }} caractèrs'
                        ]),
                        new Regex([
                            'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&].{11,255}$/",
                            'match' => true,
                            'message' => "Le mot de passe doit contentir au moins une lettre miniscule, majuscule, un chiffre et un caractère spécial.",
                        ]),
                    ],
                ],
                'invalid_message' => 'Le nouveau mot de passe doit être identique à sa confirmation.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                // 'mapped' => false,
            ])
        ;
    }
}
