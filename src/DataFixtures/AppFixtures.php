<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\Task;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $employeeData = require './data/employee_data.php';
        $projectData = require './data/project_data.php';
        $taskData = require './data/task_data.php';

        foreach ($employeeData as $row) {
            $employee = new Employee();
            $employee->setFirstname($row['firstname']);
            $employee->setLastname($row['lastname']);
            $employee->setEmail($row['email']);
            $employee->setContract($row['contract']);
            $employee->setArrivalDate($row['arrival_date']);
            $manager->persist($employee);

            $this->addReference('employee_' . strtolower($row['firstname']), $employee);
        }

        foreach ($projectData as $row) {
            $project = new Project();
            $project->setName($row['name']);
            $project->setArchive($row['archive']);

            foreach ($row['employees'] as $employee) {
                $project->addEmployee($this->getReference($employee, Employee::class));
            }
            $manager->persist($project);

            $this->addReference('project_' . strtolower($row['name']), $project);
        }

        foreach ($taskData as $row) {
            $task = new Task();
            $task->setName($row['name']);
            $task->setDeadline($row['deadline']);
            $task->setStatus($row['status']);
            $task->setDescription($row['description']);
            $task->setProject($this->getReference($row['project'], Project::class));
            $task->setEmployee($this->getReference($row['employee'], Employee::class));
            $manager->persist($task);
        }
        $manager->flush();
    }
}
