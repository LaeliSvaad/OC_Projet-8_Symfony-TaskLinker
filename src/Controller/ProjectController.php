<?php

namespace App\Controller;

use App\Enum\ProjectStatus;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project')]
    public function index(ProjectRepository $repository): Response
    {
        $projects = $repository->findBy(['archive' => '0']);
        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projet/{id}', name: 'app_show_project')]
    public function show(int $id,
                         ProjectRepository $projectRepository,
                         TaskRepository $taskRepository): Response
    {
        $project = $projectRepository->find($id);

        $tasks = $taskRepository->findBy(['project' => $project]);

        foreach (ProjectStatus::cases() as $case) {
            $groupedTasks[$case->getLabel()] = [];
        }


        foreach ($tasks as $task) {
            $groupedTasks[$task->getStatus()->getLabel()][] = $task;
        }

        return $this->render('project/project.html.twig', [
            'project' => $project,
            'groupedTasks' => $groupedTasks,
        ]);
    }

    #[Route('/edition-projet/{id}', name: 'app_edit_project')]
    public function edit(int $id): Response
    {
        return $this->render('project/project.html.twig', [

        ]);
    }

    #[Route('/suppression-projet/{id}', name: 'app_delete_project')]
    public function delete(int $id, ProjectRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $project = $repository->find($id);
        if(!$project) {
            return $this->redirectToRoute('app_project');
        }

        $project->setArchive(1);
        $entityManager->flush();

        return $this->redirectToRoute('app_project');
    }

    #[Route('/nouveau-projet', name: 'app_add_project')]
    public function add(): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        return $this->render('project/add-project.html.twig', [
            'form' => $form,
        ]);
    }

}
