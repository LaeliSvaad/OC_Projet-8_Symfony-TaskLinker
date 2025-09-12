<?php

namespace App\Form;

use App\Entity\Employee;
use App\Enum\EmployeeContract;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class, ['label' => 'Nom',
        'attr' => [
            'id' => 'firstname',
            'name' => 'firstname',
        ],])
            ->add('lastname', TextType::class, ['label' => 'Prénom',
                'attr' => [
                    'id' => 'lastname',
                    'name' => 'lastname',
                ],])
            ->add('email', EmailType::class, ['label' => 'Email',
                'attr' => [
                    'id' => 'email',
                    'name' => 'email',
                ],] )
            ->add('contract', ChoiceType::class, [
                'choices' => EmployeeContract::cases(),
                'choice_label' => fn (EmployeeContract $contract) => $contract->getLabel(),
                'choice_value' => fn (?EmployeeContract $contract) => $contract?->value,
                'attr' => [
                    'id' => 'contract',
                    'name' => 'contract',
                ],
            ])
            ->add('arrival_date', DateType::class, [
                'label' => 'Date d\'entrée',
                'attr' => [
                    'required' => 'required',
                    'name' => 'arrival_date',
                    'id' => 'arrival_date',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'button button-submit',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
