<?php

namespace App\Controller;


use App\Entity\Task;
use App\Enum\ProjectStatus;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TaskController extends AbstractController
{
    #[Route('/nouvelle-tache/{status}/{id}', name: 'app_add_task')]
    public function add(ProjectStatus $status, EntityManagerInterface $entityManager, ProjectRepository $projectRepository, Request $request): Response
    {
        $task = new Task();
        $task->setStatus($status);
        $project = $projectRepository->find($request->get('id'));
        $task->setProject($project);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();
            return $this->redirectToRoute('app_show_project', ['id' => $task->getProject()->getId()]);
        }

        return $this->render('task/add-task.html.twig', [
            'form' => $form,
            'task' => $task,
        ]);
    }

    #[Route('/edition-tache/{id}', name: 'app_edit_task')]
    public function edit(Task $task, TaskRepository $repository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_show_project', ['id' => $task->getProject()->getId()]);
        }

        return $this->render('task/edit-task.html.twig', [
            'form' => $form,
            'task' => $task,
        ]);
    }
    #[Route('/suppression-tache/{id}', name: 'app_delete_task')]
    public function delete(Task $task, TaskRepository $repository, EntityManagerInterface $entityManager, Request $request): Response
    {
        // Vérifie le token CSRF
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
            $this->addFlash('success', 'Tâche supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_show_project', ['id' => $task->getProject()->getId()]); // adapte à ta route liste
    }
}
