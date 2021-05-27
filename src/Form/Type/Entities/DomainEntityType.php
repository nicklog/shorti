<?php

declare(strict_types=1);

namespace App\Form\Type\Entities;

use App\Entity\Domain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DomainEntityType extends FormType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Domain::class,
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
