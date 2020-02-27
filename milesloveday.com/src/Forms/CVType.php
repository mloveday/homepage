<?php

namespace App\Forms;

use App\Entity\CvEmployer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('personalStatement', TextareaType::class)
            ->add('employers', CollectionType::class, ['entry_type' => CvEmployerType::class, 'allow_add' => true])
            ->add('skills', CollectionType::class, ['entry_type' => CvSkillType::class, 'allow_add' => true])
            ->add('educators', CollectionType::class, ['entry_type' => CvEducatorType::class, 'allow_add' => true])
            ->add('interests', CollectionType::class, ['entry_type' => CvInterestType::class, 'allow_add' => true])
            ->add('save', SubmitType::class)
        ;
    }
}