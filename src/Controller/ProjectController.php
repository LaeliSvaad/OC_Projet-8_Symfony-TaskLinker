<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project')]
    public function index(ProjectRepository $repository): Response
    {
        $projects = $repository->findAll();
        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projet/{id}', name: 'app_show_project')]
    public function show(int $id, ProjectRepository $repository): Response
    {
        $project = $repository->find($id);
        return $this->render('project/project.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/edition-projet/{id}', name: 'app_edit_project')]
    public function edit(int $id): Response
    {
        return $this->render('project/project.html.twig', [

        ]);
    }

    #[Route('/suppression-projet/{id}', name: 'app_delete_project')]
    public function delete(int $id): Response
    {
        return $this->render('project/project.html.twig', [

        ]);
    }

}
