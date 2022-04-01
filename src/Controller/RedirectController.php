<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Visit;
use App\Infrastructure\Logger\LoggerKeyword;
use App\Repository\ShortUrlRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class RedirectController extends AbstractController
{
    public function __construct(
        private readonly ShortUrlRepository $shortUrlRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(
        Request $request,
        string $code,
    ): Response {
        $shortUrl = $this->shortUrlRepository->findOneByCode($code);

        if ($shortUrl === null) {
            throw $this->createNotFoundException();
        }

        if (! $shortUrl->isEnabled()) {
            throw $this->createNotFoundException();
        }

        if ($shortUrl->getDomains()->count() > 0 && ! $shortUrl->getDomainsAsString()->contains($request->getHost())) {
            throw $this->createNotFoundException();
        }

        try {
            $visit = Visit::create($shortUrl)
                ->setReferer($request->server->get('HTTP_REFERER'))
                ->setRemoteAddr($request->getClientIp())
                ->setUserAgent($request->headers->get('User-Agent'));

            $shortUrl->setLastUse(Carbon::now());

            $this->entityManager->persist($visit);
            $this->entityManager->persist($shortUrl);
            $this->entityManager->flush();
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage(), [
                LoggerKeyword::EXCEPTION => $exception,
            ]);
        }

        return $this->redirect(
            $shortUrl->getUrl()
        );
    }
}
