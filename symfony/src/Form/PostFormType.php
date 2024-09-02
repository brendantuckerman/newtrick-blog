<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,  [
                'attr' => array(
                  'class' => 'bg-transparent p-8 m8 block border-b-2 w-full h-20 text-6xl outline-none',
                  'placeholder' => 'Give this post a title'
                ),
                'label_attr' => ['class' => 'post-form-label'],
                'row_attr' => ['class' => 'post-form-row-wrapper'],
            ])
            ->add('imagePath', FileType::class,  [
                'required' => false,
                'mapped' => false,
                'label' => 'Image',
                'attr' => array(
                  'class' => 'py-10 block'
                ),
                'label_attr' => ['class' => 'post-form-label'],
                'row_attr' => ['class' => 'post-form-row-wrapper']
            ])
            ->add('content',  CKEditorType::class, [
                'config_name' => 'my_config',
                'required' => false,
                'attr' => ['class' => 'ckeditor'],
                'label_attr' => ['class' => 'post-form-label'],
                'row_attr' => ['class' => 'post-form-row-wrapper']
            ])
            ->add('tags', CollectionType::class, [
                'entry_type' => TextType::class, 
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'required' => false,
                'label' => 'Tags',
                'by_reference' => false,
                'label_attr' => ['class' => 'post-form-label'],
                'row_attr' => ['class' => 'post-form-row-wrapper']
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label_attr' => ['class' => 'post-form-label'],
                'row_attr' => ['class' => 'post-form-row-wrapper'],
            ])
            ->add('published', CheckboxType::class, [
                'required' => false,
                'label' => 'Publish this post',
                'label_attr' => ['class' => 'post-form-label'],
                'row_attr' => ['class' => 'post-form-row-wrapper'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
