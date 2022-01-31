<?php

namespace App\Form;

use App\Entity\Scores;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScoresFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('scoreDate', Null, array('label' => 'Date', 'widget' => 'single_text'))
            ->add('lengthTime', Null, array('label' => 'Durée'))
            ->add('users', Null, array('label' => 'Utilisateur'))
            ->add('sites', Null, array('label' => 'Chantier'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Scores::class,
        ]);
    }
}
