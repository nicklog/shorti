<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener]
final class SetupListener
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function __invoke(RequestEvent $event): void
    {
        if (! $event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->get('_route') === 'app_setup') {
            return;
        }

        if ($this->userRepository->countAll() > 0) {
            return;
        }

        $response = new RedirectResponse(
            $this->urlGenerator->generate('app_setup')
        );

        $event->setResponse($response);
        $event->stopPropagation();
    }
}
