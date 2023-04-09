<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\Trajet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('type', TextType::class)
            ->add('adresse', TextType::class)
            ->add('description')
            ->add('trajet', EntityType::class, [
                'class' => Trajet::class,
                'choice_label' => function ($trajet) {
                    return $trajet->getDepart().' --- '.$trajet->getDestination();
                },
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
