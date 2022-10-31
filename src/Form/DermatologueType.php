<?php

namespace App\Form;

use App\Entity\Dermatologue;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DermatologueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('diplome')
            ->add('formation')
            ->add('langue',LanguageType::class,['required' => false])
            ->add('horaire',ChoiceType::class,[
                'choices'=>[
                    'du 09:00->18h:00'=>'du 09:00->18h:00',
                    'du 09:00->14h30'=>'du 09:00->14h30',
                    'du 09:00->14h00'=>'du 09:00->14h00',
                    'Pas Disponible'=>'Pas Disponible',
                    ]
                ,'group_by' => function($choice, $key, $value) {
        if (($choice == "du 09:00->18h:00") || ($choice =="du 09:00->14h30")) {
            return 'du lundi au vendredi ';
        }
        else
        return 'Samedi';
    },'required' => false,

            ])
            ->add('modereglement',ChoiceType::class,[
                'choices'=>[
                    'Cheque'=>'cheque',
                    'Espèce'=>'epece',
                    'Carte Bancaire'=>'carte bancaire',
                ]
                ,'expanded'=>true

            ])
            ->add('assurancemaladie',ChoiceType::class,[
                'choices'=>[
                    'CNAM'=>"CNAM",
                    'Biat Assurrance'=>"Biat Assurrance",
                    'Gat Assurance'=>"Gat Assurance" ,
                    'Comar Assurance'=>"Comar Assurance"
                ],'required' => false,

            ])
            ->add('image',FileType::class, array('data_class' => null))
            ->add('categorie')
            ->add('roles',ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
            ])
           /* ->add('cin')
            ->add('email')
            ->add('nom')
            ->add('prenom')

            ->add('adresse')
            ->add('numero')
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'ton  mot de passe doit etre au min  {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])*/
        ;

       /* $builder->get('modereglement')
            ->addModelTransformer(new CallbackTransformer(
                function ($modereglementArray) {
                    // transform the array to a string
                    return count($modereglementArray)? $modereglementArray[0]: null;
                },

                function ($modereglementString) {
                    // transform the string back to an array
                    return [$modereglementString];
                }));
      */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dermatologue::class,
        ]);
    }
}
