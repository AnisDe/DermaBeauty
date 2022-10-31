<?php

namespace App\Form;

use App\Entity\Centre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('nom')
            ->add('telephone')
            ->add('email')
            ->add('description')
            ->add('horaire')
            ->add('localisation')
            ->add('categorie')


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Centre::class,
        ]);
    }
}
