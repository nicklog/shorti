<?php

declare(strict_types=1);

namespace App\Form\Type\Forms;

use App\Entity\ShortUrl;
use App\Form\Type\Entities\DomainEntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

final class ShortUrlType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder->add('domain', DomainEntityType::class, [
//            'label'    => 'Domains that are this short url valid for',
//            'required' => false,
//            'multiple' => false,
//            'expanded' => true,
//        ]);

        $builder->add('code', TextType::class, [
            'label'       => 'Short-Code',
            'constraints' => [
                new NotBlank(),
            ],
            'required'    => false,
        ]);

        $builder->add('url', TextType::class, [
            'label'       => 'URL to be shortened',
            'constraints' => [
                new NotBlank(),
                new Url(),
            ],
            'required'    => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShortUrl::class,
            'html5'      => false,
        ]);
    }
}
