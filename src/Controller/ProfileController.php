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

/**
 * @Route("/admin/profile", name="app_profile_")
 */
final class ProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private FormFactoryInterface $formFactory;

    private UserPasswordHasherInterface $userPasswordHasher;

    private FlashBagHelper $flashBagHelper;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        UserPasswordHasherInterface $userPasswordHasher,
        FlashBagHelper $flashBagHelper,
    ) {
        $this->entityManager      = $entityManager;
        $this->formFactory        = $formFactory;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->flashBagHelper     = $flashBagHelper;
    }

    /**
     * @Route("", name="index")
     */
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

    /**
     * @Route("/password", name="password")
     */
    public function password(Request $request, User $user): Response
    {
        $form = $this->formFactory->create(UserPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('passwordNew')->getData();
            $user->setPassword(
                $this->userPasswordHasher->hashPassword($user, $password)
            );

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
