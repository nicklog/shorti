<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Domain;
use App\Form\Type\Forms\DomainType;
use App\Repository\DomainRepository;
use App\Service\FlashBagHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

/**
 * @IsGranted("ROLE_ADMIN")
 */
#[Route(path: '/admin/domains', name: 'app_domain_')]
final class DomainController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DomainRepository $domainRepository,
        private readonly FlashBagHelper $flashBagHelper,
        private readonly PaginatorInterface $paginator
    ) {
    }

    #[Route(path: '', name: 'index')]
    public function index(Request $request): Response
    {
        $qb = $this->domainRepository->createQueryBuilder('p');

        $page      = $request->query->getInt('page', 1);
        $sort      = $request->query->get('sort', 'p.id');
        $direction = $request->query->get('direction', 'asc');

        $qb->orderBy($sort, $direction);

        $pagination = $this->paginator->paginate($qb, $page);

        return $this->render('domain/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route(path: '/add', name: 'add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(DomainType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domain = $form->getData();
            assert($domain instanceof Domain);

            $this->entityManager->persist($domain);
            $this->entityManager->flush();

            $this->flashBagHelper->success('Domain created');

            return $this->redirectToRoute('app_domain_index');
        }

        return $this->render('short_url/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{domain}/edit', name: 'edit')]
    public function edit(Request $request, Domain $domain): Response
    {
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($domain);
            $this->entityManager->flush();

            $this->flashBagHelper->success('Domain updated');

            return $this->redirectToRoute('app_domain_index');
        }

        return $this->render('short_url/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{domain}/remove', name: 'remove')]
    public function remove(Request $request, Domain $domain): Response
    {
        $this->entityManager->remove($domain);
        $this->entityManager->flush();

        $this->flashBagHelper->success('Domain removed');

        return $this->redirectToRoute('app_domain_index');
    }
}
