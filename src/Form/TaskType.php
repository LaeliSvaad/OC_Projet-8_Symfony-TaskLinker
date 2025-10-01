<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Task;
use App\Entity\Project;
use App\Enum\ProjectStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Titre de la tâche',
                'attr' => [
                    'id' => 'name',
                    'name' => 'name',
            ],])
            ->add('description', TextareaType::class, ['label' => 'Description', 'required' => false, 'attr' => [
                'id' => 'description',
                'name' => 'description',
            ],])
            ->add('deadline', DateType::class, ['label' => 'Date', 'required' => false, 'attr' => [
                'id' => 'deadline',
                'name' => 'deadline',
            ],] )
            ->add('status', ChoiceType::class, [
                'choices' => ProjectStatus::cases(),
                'choice_label' => fn (ProjectStatus $status) => $status->getLabel(),
                'choice_value' => fn (?ProjectStatus $status) => $status?->value,
                'attr' => [
                    'id' => 'status',
                    'name' => 'status',
                ],])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choices' => $options['data']->getProject()->getEmployees(),
                'choice_label' => fn(Employee $e) => $e->getFirstname() . ' ' . $e->getLastname(),
                'placeholder' => '',
                'required' => false,
                'attr' => [
                    'id' => 'employee',
                    'name' => 'employee',
                ],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter',  'attr' => [
                'class' => 'button button-submit',
            ],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
