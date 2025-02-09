<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\Experience;
use App\Entity\Gender;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'first_name',
                    // 'required' => true,
                ],
                'label' => 'First Name',
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'last_name',
                    // 'required' => true,
                ],
                'label' => 'Last Name',
            ])
            ->add('adress', TextType::class, [
                'attr' => [
                    'id' => 'address',
                ],
                'label' => 'Adress',
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'id' => 'country',
                    // 'required' => true,
                ],
                'label' => 'Country',
            ])
            ->add('nationality', TextType::class, [
                'attr' => [
                    'id' => 'nationality',
                    // 'required' => true,
                ],
                'label' => 'Nationality',
            ])
            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'label' => 'Gender',
                'attr' => [
                    'id' => 'gender',
                    // 'required' => true,
                ],
            ])
            ->add('experience', EntityType::class, [
                'class' => Experience::class,
                'label' => 'Experience',
                'attr' => [
                    'id' => 'experience',
                    // 'required' => true,
                ],
            ])
            // ->add('isPassport')
            // ->add('file_passport')
            // ->add('file_cv')
            // ->add('file_pp')
            ->add('location' , TextType::class, [
                'attr' => [
                    'id' => 'current_location',
                    // 'required' => true,
                ],
                'label' => 'Location',
            ])
            ->add('birth_date', DateType::class, [
                'attr' => [
                    'id' => 'birth_date',
                    'class' => 'datepicker',
                ],
                'label' => 'Birth Date',
            ])
            ->add('birth_location', TextType::class, [
                'attr' => [
                    'id' => 'birth_location',
                ],
                'label' => 'Birth Place',
            ])
            // ->add('isAvailable')
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => "materialize-textarea",  
                    'id' => 'description',
                ],
                'label' => 'Description',
            ])
            ->add('notes')
            // ->add('created_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updated_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('deleted_at', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('User', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
