<?php

namespace App\Controller;

use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EmployeeController extends AbstractController
{
    #[Route('/employes', name: 'app_team')]
    public function index(EmployeeRepository $repository): Response
    {
        $employees = $repository->findAll();

        return $this->render('employee/index.html.twig', [
            'employees' => $employees,
        ]);
    }

    #[Route('/edition-employe/{id}', name: 'app_edit_employee')]
    public function edit(int $id, EmployeeRepository $repository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $employee = $repository->find($id);
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_team');
        }

        return $this->render('employee/edit-employee.html.twig', [
            'form' => $form,
            'employee' => $employee,
        ]);
    }

    #[Route('/suppression-employe/{id}', name: 'app_delete_employee')]
    public function delete(int $id, EmployeeRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $employee = $repository->find($id);
        if(!$employee) {
            return $this->redirectToRoute('app_team');
        }

        $entityManager->remove($employee);
        $entityManager->flush();

        return $this->redirectToRoute('app_team');
    }
}
