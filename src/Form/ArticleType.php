<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\MainArticle;
use App\Entity\User;
use App\Repository\AuthorRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function __construct(private AuthorRepository $authorRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $author = $this->authorRepository->findAll();

        $builder
            ->add('articleTitle', TextType::class, [
                'label' => 'Titre',
                'required' => true,
                'help' => 'Le titre de votre article.',
                'attr' => [
                    'class' => 'blockTitle'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le titre de votre article',
                    ]),
                ]
            ])
            ->add('homeTitle', TextType::class, [
                'label' => 'Titre homepage',
                'required' => true,
                'help' => 'Le titre de votre article qui sera visible sur la homepage.',
                'attr' => [
                    'class' => 'blockHomeTitle'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le titre de votre article pour la page d\'accueil',
                    ]),
                ]
            ])
            ->add('homePreview', TextareaType::class, [
                'label' => 'Description Homepage',
                'required' => true,
                'help' => 'Le texte de présentation présent sur la homepage.',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la description pour la page d\'accueil.',
                    ]),
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'help' => 'Rapide description résumant le sujet de votre article.',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la description de votre article',
                    ]),
                ]
            ])
            ->add('introduction', TextareaType::class, [
                'label' => 'Introduction',
                'required' => true,
                'help' => 'Le texte d\'introduction de votre article.',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le texte d\'introduction',
                    ]),
                ]
            ])
            ->add('detail', TextareaType::class, [
                'required' => true,
                'help' => 'Le corps de votre article.',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le corps de votre article',
                    ]),
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'help' => 'Choix du statut de votre article.',
                'required' => true,
                'choices' => [
                    'Brouillon' => '1',
                    'Publié' => '2',
                    'Archivé' => '3'
                ],
                'attr' => [
                    'class' => 'blockStatus'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le statut de votre article',
                    ]),
                ]
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'help' => 'Choix de l\'auteur qui sera crédité.',
                'label' => 'Auteur',
                'choices' => $author,
                'required' => true,
                'choice_label' => function (Author $author) {
                    return $author->getUser()->getFirstName() . ' ' . $author->getUser()->getLastName();
                },
                'attr' => [
                    'class' => 'blockAuthor'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner l\'auteur de votre article',
                    ]),
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie de l\'article',
                'class' => Category::class,
                'required' => true,
                'choice_label' => 'category_name',
                'attr' => [
                    'class' => 'blockCategory'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la categorie de votre article',
                    ]),
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Choix de l\'image',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
                'help' => 'L\'image qui illustrera votre article.',
                'constraints' => [
                    new File([
                        'maxSize' => '1M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/webp',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Votre image ne respecte pas le bon format : png, jpg, pjeg, webp',
                        'maxSizeMessage' => 'Votre image ne respecte pas la taille max : 2MO',
                        ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
