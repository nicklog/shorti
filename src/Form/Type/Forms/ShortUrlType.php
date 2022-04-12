<?php

declare(strict_types=1);

namespace App\Form\Type\Forms;

use App\Entity\ShortUrl;
use App\Form\Type\Entities\DomainEntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;

final class ShortUrlType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'label'       => 'URL to be shortened',
                'constraints' => [
                    new NotBlank(),
                    new Url(),
                ],
                'required'    => false,
                'empty_data'  => '',
            ])
            ->add('code', TextType::class, [
                'label'       => 'Short-Code',
                'required'    => false,
                'constraints' => [
                    new Type('alnum'),
                ],
                'attr'        => [
                    'placeholder' => 'ex. L1d3Ye',
                ],
                'help'        => 'If you let this empty a code will be automatically generated.',
                'empty_data'  => '',
            ])
            ->add('title', TextType::class, [
                'label'    => 'Title',
                'required' => false,
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
            'empty_data'  => static fn (FormInterface $form): ShortUrl => new ShortUrl(
                $form->get('url')->getData() ?? '',
                $form->get('code')->getData() ?? '',
            ),
            'html5'       => false,
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['code'],
                ]),
                new UniqueEntity([
                    'fields' => ['url'],
                ]),
            ],
        ]);
    }
}
