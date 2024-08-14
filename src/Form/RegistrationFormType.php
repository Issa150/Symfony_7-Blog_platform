<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'First name',
                'attr' => ['placeholder' => 'First name']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last name',
                'attr' => ['placeholder' => 'Last name']
            ])
            ->add('username', TextType::class, [
                'label' => 'Username',
                'attr' => ['placeholder' => 'Username']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Email'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Password',
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
            ->add('passwordRepeat', PasswordType::class, [
                'mapped' => false,
                'label' => 'Repeat password',
                'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Repeat password'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Assert\Callback(function ($object, ExecutionContextInterface $context) {
                        $form = $context->getRoot(); // Get the form
                        $plainPassword = $form->get('plainPassword')->getData();
                        $passwordRepeat = $form->get('passwordRepeat')->getData();
                        if ($plainPassword !== $passwordRepeat) {
                            $context->buildViolation('The passwords does not match')
                                ->atPath('passwordRepeat')
                                ->addViolation();
                        }
                    }),
                ],

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'I agree to the terms',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
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
