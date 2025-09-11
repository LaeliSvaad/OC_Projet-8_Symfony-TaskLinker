<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project')]
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [

        ]);
    }

    #[Route('/projet/{id}', name: 'app_show_project')]
    public function show(): Response
    {
        return $this->render('project/project.html.twig', [

        ]);
    }

    #[Route('/edition-projet/{id}', name: 'app_edit_project')]
    public function edit(): Response
    {
        return $this->render('project/project.html.twig', [

        ]);
    }

    #[Route('/suppression-projet/{id}', name: 'app_delete_project')]
    public function delete(): Response
    {
        return $this->render('project/project.html.twig', [

        ]);
    }

}
