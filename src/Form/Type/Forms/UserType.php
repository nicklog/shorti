<?php

declare(strict_types=1);

namespace App\Form\Type\Forms;

use App\Domain\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label'       => 'Mail address',
                'constraints' => [
                    new NotBlank(),
                ],
                'empty_data'  => '',
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'mapped'   => false,
                'label'    => 'Password',
            ])
            ->add('roles', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'choices'  => [
                    'Admin' => Role::ADMIN,
                ],
            ])
            ->add('enable', CheckboxType::class, [
                'required' => false,
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
