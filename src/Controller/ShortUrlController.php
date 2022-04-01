<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Form\Type\Forms\ShortUrlType;
use App\Repository\ShortUrlRepository;
use App\Service\FlashBagHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[Route(path: '/admin/short-urls', name: 'app_short_url_')]
final class ShortUrlController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private ShortUrlRepository $shortUrlRepository;

    private FlashBagHelper $flashBagHelper;

    private PaginatorInterface $paginator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ShortUrlRepository $shortUrlRepository,
        FlashBagHelper $flashBagHelper,
        PaginatorInterface $paginator,
    ) {
        $this->entityManager      = $entityManager;
        $this->shortUrlRepository = $shortUrlRepository;
        $this->flashBagHelper     = $flashBagHelper;
        $this->paginator          = $paginator;
    }

    #[Route(path: '/', name: 'index')]
    public function index(Request $request): Response
    {
        $qb = $this->shortUrlRepository->createQueryBuilder('p');

        $page      = $request->query->getInt('page', 1);
        $sort      = $request->query->filter('sort', 'p.id');
        $direction = $request->query->filter('direction', 'desc');

        $qb->orderBy($sort, $direction);

        $pagination = $this->paginator->paginate($qb, $page);

        return $this->render('short_url/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route(path: '/add', name: 'add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(ShortUrlType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shortUrl = $form->getData();
            assert($shortUrl instanceof ShortUrl);

            $this->entityManager->persist($shortUrl);
            $this->entityManager->flush();

            $this->flashBagHelper->success('ShortUrl created');

            return $this->redirectToRoute('app_short_url_index');
        }

        return $this->render('short_url/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{shortUrl}/edit', name: 'edit')]
    public function edit(Request $request, ShortUrl $shortUrl): Response
    {
        $form = $this->createForm(ShortUrlType::class, $shortUrl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($shortUrl);
            $this->entityManager->flush();

            $this->flashBagHelper->success('ShortUrl updated');

            return $this->redirectToRoute('app_short_url_index');
        }

        return $this->render('short_url/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{shortUrl}/remove', name: 'remove')]
    public function remove(Request $request, ShortUrl $shortUrl): Response
    {
        $this->entityManager->remove($shortUrl);
        $this->entityManager->flush();

        $this->flashBagHelper->success('ShortUrl removed');

        return $this->redirectToRoute('app_short_url_index');
    }

    #[Route(path: '/{shortUrl}/enable', name: 'enable')]
    public function enable(Request $request, ShortUrl $shortUrl): Response
    {
        $shortUrl->enable();

        $this->entityManager->persist($shortUrl);
        $this->entityManager->flush();

        $this->flashBagHelper->success('ShortUrl enabled');

        return $this->redirectToRoute('app_short_url_index');
    }

    #[Route(path: '/{shortUrl}/disable', name: 'disable')]
    public function disable(Request $request, ShortUrl $shortUrl): Response
    {
        $shortUrl->disable();

        $this->entityManager->persist($shortUrl);
        $this->entityManager->flush();

        $this->flashBagHelper->success('ShortUrl disabled');

        return $this->redirectToRoute('app_short_url_index');
    }
}
