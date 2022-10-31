<?php

namespace App\Form;

use App\Entity\Produit;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Reference_P')
            ->add('Nom_P')
            ->add('Type_P')
            ->add('Marque_P')
            ->add('Prix_P')
            ->add('Quantite_P')
            ->add('Image_P', FileType::class, array('data_class' => null))
            ->add('Description_P')
            ->add('Categorie')
            ->add('Couleur', ColorType::class)
            //->add('submit', SubmitType::class,['attr'=>['formnovalidate'=>'formnovalidate']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
