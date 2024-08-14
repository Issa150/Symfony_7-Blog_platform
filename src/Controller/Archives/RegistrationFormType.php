<?php

//  namespace App\Form;

// use App\Entity\Users;
// use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\Validator\Constraints\Email;
// use Symfony\Component\Validator\Constraints\IsTrue;
// use Symfony\Component\Validator\Constraints\Length;
// use Symfony\Component\Validator\Constraints\NotBlank;
// use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\EmailType;
// use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
// use Symfony\Component\Form\Extension\Core\Type\PasswordType;

// class RegistrationFormType extends AbstractType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options): void
//     {
//         $builder
//         ->add('firstname', TextType::class, [
//             'label' => 'First name',
//             'attr' => ['placeholder' => 'First name'],
//             // 'constraints' => [
//             //         new NotBlank(),
//             //         new Length(['min' => 3, 'max' => 50]),
//             //     ],
//         ])
//         ->add('lastname', TextType::class, [
//             'label' => 'Last name',
//             'attr' => ['placeholder' => 'Last name'],
//             // 'constraints' => [
//             //         new NotBlank(),
//             //         new Length(['min' => 3, 'max' => 50]),
//             //     ],
//         ])
//         ->add('username', TextType::class, [
//             'label' => 'Username',
//             'attr' => ['placeholder' => 'Username'],
//             // 'constraints' => [
//             //         new NotBlank(),
//             //         new Length(['min' => 6, 'max' => 20]),
//             //     ],
//         ])
//         ->add('email', EmailType::class, [
//             'label' => 'Email',
//             'attr' => ['placeholder' => 'Email'],
//         ])
//         ->add('plainPassword', PasswordType::class, [
//             'mapped' => false,
//             'label' => 'Password',
//             'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Password'],
//             // 'constraints' => [
//             //     new NotBlank([
//             //         'message' => 'Please enter a password',
//             //     ]),
//             //     new Length([
//             //         'min' => 6,
//             //         'minMessage' => 'Your password should be at least {{ limit }} characters',
//             //         // max length allowed by Symfony for security reasons
//             //         'max' => 4096,
//             //     ]),
//             // ],
//         ])
//         ->add('passwordRepeat', PasswordType::class, [
//             'mapped' => false,
//             'label' => 'Repeat password',
//             'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Repeat password'],
//             // 'constraints' => [
//             //     new NotBlank([
//             //         'message' => 'Please repeat your password',
//             //     ]),
//             //     new Length([
//             //         'min' => 6,
//             //         'minMessage' => 'Your password should be at least {{ limit }} characters',
//             //         // max length allowed by Symfony for security reasons
//             //         'max' => 4096,
//             //     ]),
//             // ],
//         ])
//         ->add('agreeTerms', CheckboxType::class, [
//             'mapped' => false,
//             'label' => 'I agree to the terms',
//             'constraints' => [
//                 new IsTrue([
//                     'message' => 'You should agree to our terms.',
//                 ]),
//             ],
//         ])
//     ;
//     }

//     public function configureOptions(OptionsResolver $resolver): void
//     {
//         $resolver->setDefaults([
//             'data_class' => Users::class,
//         ]);
//     }
// }
