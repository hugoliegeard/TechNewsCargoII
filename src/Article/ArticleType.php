<?php

namespace App\Article;


use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            # Champ Titre
            ->add('titre', TextType::class, [
                'required' => true,
                'label' => "Titre de l'article",
                'attr' => [
                    'placeholder' => "Titre de l'article"
                ]
            ])

            # Champ Catégorie
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])

            # Champ Contenu
            ->add('contenu', CKEditorType::class, [
                'required' => true,
                'label' => false,
                'config' => [
                    'toolbar' => 'standard'
                ]
            ])
            # Image de l'article
            ->add('featuredImage', FileType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'dropify',
                    'data-default-file' => $options['image_url']
                ]
            ])
            # Special et Spotlight
            ->add('special', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-on' => 'Oui',
                    'data-off' => 'Non'
                ]
            ])
            ->add('spotlight', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-on' => 'Oui',
                    'data-off' => 'Non'
                ]
            ])

            # Bouton Submit
            ->add('submit', SubmitType::class, [
                'label' => 'Publier mon Article'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => Article::class,
            'image_url' => null
        ]);
    }


}