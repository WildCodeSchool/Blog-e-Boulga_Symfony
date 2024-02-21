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
            ])
            ->add('homeTitle', TextType::class, [
                'label' => 'Titre homepage',
                'required' => true,
                'help' => 'Le titre de votre article qui sera visible sur la homepage.',
            ])
            ->add('homePreview', TextareaType::class, [
                'label' => 'Description Homepage',
                'required' => true,
                'help' => 'Le texte de présentation présent sur la homepage.',
                ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'help' => 'Rapide description résumant le sujet de votre article.',
            ])
            ->add('introduction', TextareaType::class, [
                'label' => 'Introduction',
                'required' => true,
                'help' => 'Le texte d\'introduction de votre article.',
                ])
            ->add('detail', TextareaType::class, [
                'required' => true,
                'help' => 'Le corps de votre article.',
                ])

            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'help' => 'Choix du statut de votre article.',
                'required' => true,
                'choices' => [
                    'Brouillon' => '1',
                    'Publié' => '2',
                    'Archivé' => '3'
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
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie de l\'article',
                'class' => Category::class,
                'required' => true,
                'choice_label' => 'category_name',
            ])
            ->add('imgSrc', TextType::class, [
                'label' => 'Choix de l\'image',
                'required' => true,
                'help' => 'L\'image qui illustrera votre article.',
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
