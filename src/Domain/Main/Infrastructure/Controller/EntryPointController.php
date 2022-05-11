<?php

namespace App\Domain\Main\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/* Контроллер, который возвращает точку входа в приложение */
class EntryPointController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route(path: "/", methods: "GET")]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}