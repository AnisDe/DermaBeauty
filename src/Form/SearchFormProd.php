<?php


namespace App\Form;

use App\Data\SearchProd;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormBuilderInterface;

class SearchFormProd extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q',TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Marque '
                ]
            ])
            ->add('min',NumberType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'min'
                ]
            ])
            ->add('max',NumberType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>' max'
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>SearchProd::class,
            'method'=>'GET',
            'csrf_protection'=>false

        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}