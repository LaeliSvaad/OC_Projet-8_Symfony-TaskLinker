<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TeamController extends AbstractController
{
    #[Route('/employes', name: 'app_team')]
    public function index(): Response
    {
        return $this->render('team/index.html.twig', [

        ]);
    }

    #[Route('/edition-employe/{id}', name: 'app_edit_employee')]
    public function edit(): Response
    {
        return $this->render('team/index.html.twig', [

        ]);
    }

    #[Route('/suppression-employe/{id}', name: 'app_delete_employee')]
    public function delete(): Response
    {
        return $this->render('team/index.html.twig', [

        ]);
    }
}
