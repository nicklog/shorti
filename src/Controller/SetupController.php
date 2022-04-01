<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Role;
use App\Entity\User;
use App\Form\Type\Forms\UserSetupType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[Route(path: '/admin/setup', name: 'app_setup')]
final class SetupController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if ($this->userRepository->countAll() > 0) {
            return $this->redirectToRoute('app_index');
        }

        $form = $this->createForm(UserSetupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $user     = $form->getData();
            assert($user instanceof User);

            $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
            $user->addRole(Role::ADMIN);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('setup/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
