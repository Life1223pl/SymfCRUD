<?php

namespace App\Form;

use Symfony\Component\Form\FormTypeInterface;
use App\Entity\Article;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('body', TextareaType::class, ['required' => 'false', 'attr' => ['class' => 'form-control']])
            ->add('Save', SubmitType::class, ['label' => "Create", 'attr' => ['class' => 'btn btn-primary mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'article_item'
        ]);
    }
}
