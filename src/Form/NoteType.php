<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Note;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('partielle')
            ->add('final')
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class
            ])
            ->add('student', EntityType::class, [
                'class' => Student::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
