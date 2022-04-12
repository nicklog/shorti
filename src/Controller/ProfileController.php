<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\Forms\UserPasswordType;
use App\Form\Type\Forms\UserProfileType;
use App\Service\FlashBagHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/profile', name: 'app_profile_')]
final class ProfileController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly FlashBagHelper $flashBagHelper
    ) {
    }

    #[Route(path: '', name: 'index')]
    public function profile(Request $request, User $user): Response
    {
        $form = $this->formFactory->create(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->flashBagHelper->success('Profile updated');

            return $this->redirectToRoute($request->get('_route'));
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/password', name: 'password')]
    public function password(Request $request, User $user): Response
    {
        $form = $this->formFactory->create(UserPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password       = $form->get(UserPasswordType::FIELD_PASSWORD_NEW)->getData();
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $password);

            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->flashBagHelper->success('Password updated');

            return $this->redirectToRoute($request->get('_route'));
        }

        return $this->render('profile/change_password.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
}
