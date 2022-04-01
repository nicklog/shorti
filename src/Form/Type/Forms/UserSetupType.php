<?php

declare(strict_types=1);

namespace App\Form\Type\Forms;

use App\Entity\User;
use App\Form\Type\Widgets\NewPasswordType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserSetupType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label'       => 'Mail',
                'attr'        => ['placeholder' => 'Mail address'],
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
                'empty_data'  => '',
            ])
            ->add('password', NewPasswordType::class, [
                'first_options'  => [
                    'label' => 'Password',
                    'attr'  => ['placeholder' => 'Your password'],
                ],
                'second_options' => [
                    'label' => false,
                    'attr'  => ['placeholder' => 'Repeat your password'],
                ],
                'mapped'         => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'  => User::class,
            'empty_data'  => static function (FormInterface $form): User {
                return new User(
                    $form->get('email')->getData() ?? ''
                );
            },
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['email'],
                ]),
            ],
        ]);
    }
}
