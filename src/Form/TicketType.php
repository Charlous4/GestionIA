<?php

namespace App\Form;

use App\Entity\Ingenieur;
use App\Entity\Ticket;
use App\Entity\Version;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('priorite')
            ->add('version', EntityType::class, [
                'class' => Version::class,
                'choice_label' => 'nom',
            ])
            ->add('ingenieur', EntityType::class, [
                'class' => Ingenieur::class,
                
                'choice_label' => function (Ingenieur $inge) { return $inge->getNom() . ' ' . $inge->getPrenom();},
                
                
                'required' => false,
                
                
                'placeholder' => '-- Aucun ingénieur (À attribuer) --',
            ])
        ; 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
