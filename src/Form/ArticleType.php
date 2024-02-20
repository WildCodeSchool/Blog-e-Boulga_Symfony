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
                'required' => true,
            ])
            ->add('homeTitle', TextType::class, [
                'required' => true,
            ])
            ->add('imgSrc', TextType::class, [
                'required' => true,
            ])
            ->add('homePreview', TextareaType::class, [
                'required' => true,])
            ->add('introduction', TextareaType::class, [
                'required' => true,])
            ->add('detail', TextareaType::class, [
                'required' => true,])
            ->add('description', TextareaType::class, [
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'required' => true,
                'choices' => [
                    'Brouillon' => '1',
                    'Publié' => '2',
                    'Archivé' => '3'
                ]
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choices' => $author,
                'required' => true,
                'choice_label' => function (Author $author) {
                    return $author->getUser()->getFirstName() . ' ' . $author->getUser()->getLastName();
                },
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'required' => true,
                'choice_label' => 'category_name',
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
