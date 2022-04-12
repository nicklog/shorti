<?php

declare(strict_types=1);

namespace App\Form\Type\Forms;

use App\Entity\ShortUrl;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

final class ShortUrlQuickType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('url', TextType::class, [
            'label'       => 'URL to be shortened',
            'constraints' => [
                new NotBlank(),
                new Url(),
            ],
            'required'    => false,
            'empty_data'  => '',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'  => ShortUrl::class,
            'empty_data'  => static fn (FormInterface $form): ShortUrl => new ShortUrl(
                $form->get('url')->getData() ?? ''
            ),
            'html5'       => false,
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['url'],
                ]),
            ],
        ]);
    }
}
