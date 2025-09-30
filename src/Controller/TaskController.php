<?php

namespace App\Controller;


use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TaskController extends AbstractController
{
    #[Route('/nouvelle-tache/', name: 'app_add_task')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {
        $task = new Task();
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
    public function edit(int $id, TaskRepository $repository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $task = $repository->find($id);
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
    public function delete(int $id, TaskRepository $repository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $task = $repository->find($id);
        $entityManager->flush();
        return $this->redirectToRoute('app_show_project', ['id' => $task->getProject()->getId()]);

    }
}
