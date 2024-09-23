<?php

namespace App\Form;

use App\Entity\ContentType;
use App\Entity\Posts;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('featuredImage')
            ->add('published')
            ->add('userId', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
            ->add('contentTypeId', EntityType::class, [
                'class' => ContentType::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
