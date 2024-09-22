<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
            ])
            ->add('imageCover', FileType::class, [
                'label' => 'Image Cover',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                    ]),
                ],
            ])
            ->add('imageProfile', FileType::class, [
                'label' => 'Image Profile',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
            ])
            ->add('gender', ChoiceType::class, [
                'multiple' => false,
                'expanded' => true,
                'label' => 'Gender',
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
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