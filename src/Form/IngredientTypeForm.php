<?php

namespace App\Form;

use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


class IngredientTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('name', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '2',
                'maxlength' => '50'
            ],
            'label' => 'Nom',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])
        ->add('price', MoneyType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Prix',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])
        ->add('submit', SubmitType::class)
    ;
}
}
