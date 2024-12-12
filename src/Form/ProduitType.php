<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Produit;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('taille')
            ->add('poid')
            ->add('famille')
            ->add('prix')
            ->add('category',  EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'titre'

            ])
            ->add('photo', FileType::class,[
                'required' => false,
                'mapped' => false,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
