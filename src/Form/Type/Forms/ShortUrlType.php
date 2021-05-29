<?php

declare(strict_types=1);

namespace App\Form\Type\Forms;

use App\Entity\ShortUrl;
use App\Form\Type\Entities\DomainEntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ShortUrlType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label'    => 'Short-Code',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'ex. L1d3Ye',
                ],
                'help'     => 'If you let this empty a code will be automatically generated.',
            ])
            ->add('domains', DomainEntityType::class, [
                'label'        => 'Domains that are this short url valid for',
                'multiple'     => true,
                'expanded'     => true,
                'by_reference' => false,
                'help'         => 'If you do not select a domain, the short url will be valid for every domain.',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'  => ShortUrl::class,
            'html5'       => false,
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['code'],
                ]),
            ],
        ]);
    }

    public function getParent(): string
    {
        return ShortUrlQuickType::class;
    }
}
