<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UserAccountSettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Please choose a new password',
                'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Password'],
                'constraints' => [
                    new NotBlank(['message' => 'Password cannot be blank']),
                    new Length(['min' => 6, 'minMessage' => 'Password should be at least {{ limit }} characters']),
                    new Regex(['pattern' => '/\d/', 'message' => 'Password should contain at least one digit']),
                    new Regex(['pattern' => '/[A-Z]/', 'message' => 'Password should contain at least one uppercase letter']),
                    new Regex(['pattern' => '/[a-z]/', 'message' => 'Password should contain at least one lowercase letter']),
                    new Regex(['pattern' => '/[!@#$%^&*(),.?":{}|<>]/', 'message' => 'Password should contain at least one special character']),
                ],
            ])
            // ->add('passwordRepeat', PasswordType::class, [
            //     'mapped' => false,
            //     'label' => 'Please repeat the password',
            //     'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Repeat password'],
            //     'constraints' => [
            //         new Assert\NotBlank([
            //             'message' => 'Please enter a password',
            //         ]),
            //         new Assert\Callback(function ($object, ExecutionContextInterface $context) {
            //             $form = $context->getRoot(); // Get the form
            //             $plainPassword = $form->get('password')->getData();
            //             $passwordRepeat = $form->get('passwordRepeat')->getData();
                        
            //             if (!empty($plainPassword) && empty($passwordRepeat)) {
            //                 $context->buildViolation('Please repeat your password')
            //                     ->atPath('passwordRepeat')
            //                     ->addViolation();
            //             } elseif (!empty($plainPassword) && $plainPassword !== $passwordRepeat) {
            //                 $context->buildViolation('The passwords does not match')
            //                     ->atPath('passwordRepeat')
            //                     ->addViolation();
            //             }
            //         }),
            //     ],

            // ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
