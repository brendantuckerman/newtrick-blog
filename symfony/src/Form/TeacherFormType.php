<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TeacherFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
              'attr' => array(
                'class' => 'bg-transparent p-8 m8 block border-b-2 w-full h-20 text-6xl outline-none',
                'placeholder' => 'Enter  first name...'
                )
              ]
            )
            ->add('lastName', TextType::class,  [
              'attr' => array(
                'class' => 'bg-transparent p-8 m8 block border-b-2 w-full h-20 text-6xl outline-none',
                'placeholder' => 'Enter last name...'
                )
              ]
            )
            ->add('imagePath', FileType::class,  [
              'attr' => array(
                'class' => 'py-10 block'
                )
              ]
            )
            /*->add('students', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
