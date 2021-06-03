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
 * @Route("/admin/domains", name="app_domain_")
 * @IsGranted("ROLE_ADMIN")
 */
final class DomainController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private DomainRepository $domainRepository;

    private FlashBagHelper $flashBagHelper;

    private PaginatorInterface $paginator;

    public function __construct(
        EntityManagerInterface $entityManager,
        DomainRepository $domainRepository,
        FlashBagHelper $flashBagHelper,
        PaginatorInterface $paginator,
    ) {
        $this->entityManager    = $entityManager;
        $this->domainRepository = $domainRepository;
        $this->flashBagHelper   = $flashBagHelper;
        $this->paginator        = $paginator;
    }

    /**
     * @Route("", name="index")
     */
    public function index(Request $request): Response
    {
        $qb = $this->domainRepository->createQueryBuilder('p');

        $page = $request->query->getInt('page', 1);

        $sort      = $request->query->filter('sort', 'p.id');
        $direction = $request->query->filter('direction', 'asc');

        $qb->orderBy($sort, $direction);

        $pagination = $this->paginator->paginate($qb, $page);

        return $this->render('domain/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
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

    /**
     * @Route("/{domain}/edit", name="edit")
     */
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

    /**
     * @Route("/{domain}/remove", name="remove")
     */
    public function remove(Request $request, Domain $domain): Response
    {
        $this->entityManager->remove($domain);
        $this->entityManager->flush();

        $this->flashBagHelper->success('Domain removed');

        return $this->redirectToRoute('app_domain_index');
    }
}
