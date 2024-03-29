<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Maker;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('picture')
            ->add('startingPrice')
            ->add('currentPrice')
            ->add('show')
            ->add('maker', EntityType::class, [
                'class' => Maker::class,
'choice_label' => 'id',
            ])
            ->add('season', EntityType::class, [
                'class' => Season::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
