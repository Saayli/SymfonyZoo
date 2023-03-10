<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Enclos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumId')
            ->add('Nom')
            ->add('DateArrivee')
            ->add('DateDepart')
            ->add('Proprietaire')
            ->add('Genre')
            ->add('Espece')
            ->add('Sterelise')
            ->add('Quarantaine')
            ->add('Enclo', EntityType::class, [
                'class' => Enclos::class,
                'choice_label' => "Nom",
                'multiple' => false,
                'expanded' => false
            ])
            ->add('OK', SubmitType::class, ["label" => "OK"]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
