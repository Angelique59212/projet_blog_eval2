<?php

namespace App\Form;

use App\Entity\Article;

use phpDocumentor\Reflection\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'title'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'data_class' => null,

            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'rows' => 10,
                    'cols' => 10,
                    'maxlength' => 255,
                    'minlength' => 10,
                ],
                'label' => 'Contenu',
                'label_attr' => [
                    'class' => 'title'
                ]
            ])
            ->add('author')
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
            ->add('submit_draft', SubmitType::class, [
                'label' => 'Enregistrer en tant que brouillon',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
