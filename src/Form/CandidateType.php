<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\Category;
use App\Entity\Experience;
use App\Entity\Gender;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Category',
                'attr' => [
                    'placeholder' => 'Type in or Select job sector you would be interested in.',
                    'id' => 'job_sector',
                ],
            ])
            // ->add('isPassport')
            ->add('file_passport', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF, JPG, DOC, DOCX, PNG, or GIF document',
                    ]),
                ],
                'attr' => [
                    'accept' => '.pdf,.jpg,.doc,.docx,.png,.gif',
                    'id' => 'passport',
                    // 'required' => true,
                ],
            ])
            ->add('file_cv', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF, JPG, DOC, DOCX, PNG, or GIF document',
                    ]),
                ],
                'attr' => [
                    'accept' => '.pdf,.jpg,.doc,.docx,.png,.jpeg',
                    'id' => 'cv',
                    // 'required' => true,
                ],
            ])
            ->add('file_pp', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF, JPG, DOC, DOCX, PNG, or GIF document',
                    ]),
                ],
                'attr' => [
                    'accept' => '.pdf,.jpg,.doc,.docx,.png,.gif',
                    'id' => 'photo',
                    // 'required' => true,
                ],
            ])
            ->add('location', TextType::class, [
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
                    'col' => '50',
                    'row' => '10',
                ],
                'label' => 'Description',
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, $this->setUpdateAt(...))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }

    private function setUpdateAt(FormEvent $e): void
    {
        $candidate = $e->getData();
        $candidate->setUpdatedAt(new DateTimeImmutable());
    }
}
