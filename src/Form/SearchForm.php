<?php


namespace App\Form;


use App\Data\Search;
use App\Entity\CategorieCentre;
use Doctrine\DBAL\Types\TextType;
use Faker\Provider\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Rechercher '
                ]
            ])
            ->add('categories' , EntityType::class, [
                'label'=>false,
                'required'=>false,
                'class'=> CategorieCentre::class,
                'expanded'=>true,
                'multiple'=>true
            ])

            ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class'=>Search::class,
            'method'=>'GET',
            'csrf_protection'=>false

        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }

}