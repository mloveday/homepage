<?php

namespace App\Forms;

use App\Entity\CvEmployer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CvEmployerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dates', TextType::class)
            ->add('name', TextType::class)
            ->add('jobTitle', TextType::class)
            ->add('description', TextareaType::class)
            ->add('archived', CheckboxType::class, ['required' => false])
            ->add('displayOrder', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('data_class', CvEmployer::class);
    }
}