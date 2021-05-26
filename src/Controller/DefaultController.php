<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\Forms\ShortUrlQuickType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("", name="app_")
 */
final class DefaultController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        $form = $this->createForm(ShortUrlQuickType::class);

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
