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
                'label_attr' => [
                    'class' => 'title'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Cover image',
                'mapped' => false,
                'data_class' => null,

            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'rows' => 8,
                    'cols' => 4,
                    'maxlength' => 255,
                    'minlength' => 10,
                ],
                'label_attr' => [
                    'class' => 'title'
                ]
            ])

            ->add('author')
            ->add('submit', SubmitType::class, [
                'label' => 'Save'
            ])
            ->add('submit_draft', SubmitType::class, [
                'label' => 'Save as draft'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
