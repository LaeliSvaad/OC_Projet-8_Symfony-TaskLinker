<?php

namespace App\Controller;

use App\Enum\ProjectStatus;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        //$tasks = $taskRepository->findBy(['project' => $project]);
        $tasks = $taskRepository->findByProjectWithTaskEmployee(['project' => $project]);

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

    #[Route('/nouveau-projet', name: 'app_add_project')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('app_show_project', ['id' => $project->getId()]);
        }

        return $this->render('project/add-project.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edition-projet/{id}', name: 'app_edit_project')]
    public function edit(int $id, ProjectRepository $repository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $project = $repository->find($id);
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_show_project', ['id' => $project->getId()]);
        }

        return $this->render('project/edit-project.html.twig', [
            'form' => $form,
            'project' => $project,
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
}
