<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\User;
use App\Entity\UserItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price')
            ->add('relatedUser', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
            ->add('item', EntityType::class, [
                'class' => Item::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserItem::class,
        ]);
    }
}
