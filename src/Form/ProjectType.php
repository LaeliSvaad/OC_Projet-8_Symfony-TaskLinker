<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Titre du projet', 'attr' => [
                'id' => 'name',
                'name' => 'name',
            ],])
            ->add('employees', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => function(Employee $employee) {
                    return $employee->getFirstname() . ' ' . $employee->getLastname();
                },
                'multiple' => true,
                'label' => 'Inviter des membres',
                'attr' => [
                    'id' => 'employees',
                    'name' => 'employees',
                ],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Continuer',  'attr' => [
                'class' => 'button button-submit',
            ],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
