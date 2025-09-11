<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function edit(): Response
    {
        return $this->render('employee/index.html.twig', [

        ]);
    }

    #[Route('/suppression-employe/{id}', name: 'app_delete_employee')]
    public function delete(): Response
    {
        return $this->render('employee/index.html.twig', [

        ]);
    }
}
