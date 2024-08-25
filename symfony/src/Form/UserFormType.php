<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class)
        ->add('roles', ChoiceType::class, [
            'choices' => [
                // 'User' => 'ROLE_USER', (Default)
                'Staff' => 'ROLE_STAFF',
                'Student' => 'ROLE_STUDENT',
                'Content Editor' => 'ROLE_CONTENT_EDITOR',
                'Admin' => 'ROLE_ADMIN',
                'Super Admin' => 'ROLE_SUPER_ADMIN',

            ],
            'multiple' => true,
            'expanded' => true, // use checkboxes
        ])
            ->add('password', PasswordType::class, [
              // instead of being set onto the object directly,
              // this is read and encoded in the controller
              'mapped' => false,
              'label' => 'Password (min 8 chars)',
              'attr' => [
                  'autocomplete' => 'new-password',
                  'class' => 'bg-transparent block mb-10 mx-auto border-b-2 w-1/5 h-20 text-2xl outline-none',
                  'placeholder' => 'Password'
              
              ]
            ])
            ->add('isVerified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
