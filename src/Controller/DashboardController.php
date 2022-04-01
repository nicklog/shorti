<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Form\Type\Forms\ShortUrlQuickType;
use App\Repository\ShortUrlRepository;
use App\Repository\VisitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[Route(path: '/admin', name: 'app_index')]
final class DashboardController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ShortUrlRepository $shortUrlRepository,
        private readonly VisitRepository $visitRepository
    ) {
    }

    public function __invoke(
        Request $request,
        string $_route
    ): Response {
        $form = $this->createForm(ShortUrlQuickType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shortUrl = $form->getData();
            assert($shortUrl instanceof ShortUrl);

            $this->entityManager->persist($shortUrl);
            $this->entityManager->flush();

            return $this->redirectToRoute($_route);
        }

        return $this->render('default/index.html.twig', [
            'form'                     => $form->createView(),
            'countVisits'              => $this->visitRepository->countAll(),
            'countShortUrls'           => $this->shortUrlRepository->countAll(),
            'recentlyCreatedShortUrls' => $this->shortUrlRepository->findRecentlyCreated(),
        ]);
    }
}
