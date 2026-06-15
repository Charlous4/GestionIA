<?php

namespace App\Form;

use App\Entity\IA;
use App\Entity\Version;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('statut', ChoiceType::class, [
                'label' => 'Choisissez une option',
                'choices' => [
                    'Fonctionnel' => 'ok', // Si pas de ticket
                    'En Etude' => 'mid', // Si ticket pas prio  
                    'Défaillante' => 'pas_ok', // Si ticket prio
                ],
            ])
            ->add('ia', EntityType::class, [
                'class' => IA::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Version::class,
        ]);
    }
}
