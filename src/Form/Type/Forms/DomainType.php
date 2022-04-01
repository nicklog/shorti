<?php

declare(strict_types=1);

namespace App\Form\Type\Forms;

use App\Entity\Domain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class DomainType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, [
            'label'       => 'Name',
            'constraints' => [
                new NotBlank(),
            ],
            'required'    => false,
            'empty_data'  => '',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Domain::class,
            'empty_data' => static function (FormInterface $form): Domain {
                return new Domain(
                    $form->get('name')->getData() ?? ''
                );
            },
            'html5'      => false,
        ]);
    }
}
