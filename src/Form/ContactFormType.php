<?php

namespace App\Form;

use App\Entity\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom :',
                'attr' => [
                    'placeholder' => 'John',
                    'class' => 'input_form',
                    'id' => 'firstName',
                    'required' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom',
                    ]),
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre nom :',
                'attr' => [
                    'placeholder' => 'Doe',
                    'class' => 'input_form',
                    'id' => 'lastName',
                    'required' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom',
                    ]),
                ]
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'Votre email :',
                'attr' => [
                    'placeholder' => 'john@doe.com',
                    'class' => 'input_form',
                    'id' => 'mail',
                    'required' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre email',
                    ]),
                ]
            ])
            ->add('topic', ChoiceType::class, [
                'label' => 'Sujet de votre message :',
                'choices' => [
                    'Demande de renseignements' => 'Demande de renseignements',
                    'Conseil d\'ajout de thème d\'article' => 'Conseil d\'ajout de thème d\'article',
                    'Signaler un bug' => 'Signaler un bug',
                    'Contacter l\'équipe' => 'Contacter l\'équipe',
                    'Autre' => 'Autre'
                ],
                'attr' => [
                    'class' => 'input_form',
                    'id' => 'topic',
                    'required' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le sujet de votre message',
                    ]),
                ]
            ])
            ->add('messageContent', TextareaType::class, [
                'label' => 'Votre message :',
                'attr' => [
                    'placeholder' => 'Votre message ici...',
                    'class' => 'input_form',
                    'id' => 'message',
                    'required' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre message',
                    ]),
                ]
            ])
            ->add('terms', CheckboxType::class, [
                'label' => false,
                'attr' => [
                    'id' => 'terms',
                    'required' => 'required',
                    'class' => 'input_form'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Form::class,
        ]);
    }
}
