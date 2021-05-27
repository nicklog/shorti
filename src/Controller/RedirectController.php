<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ShortUrlRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RedirectController extends AbstractController
{
    private ShortUrlRepository $shortUrlRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(
        ShortUrlRepository $shortUrlRepository,
        EntityManagerInterface $entityManager,
    ) {
        $this->shortUrlRepository = $shortUrlRepository;
        $this->entityManager      = $entityManager;
    }

    public function __invoke(
        Request $request,
        string $code,
    ): Response {
        $shorty = $this->shortUrlRepository->findOneByCode($code);

        if ($shorty === null) {
            throw $this->createNotFoundException();
        }

        $shorty->setLastUse(Carbon::now());

        $this->entityManager->persist($shorty);
        $this->entityManager->flush();

        return $this->redirect(
            $shorty->getUrl()
        );
    }
}
