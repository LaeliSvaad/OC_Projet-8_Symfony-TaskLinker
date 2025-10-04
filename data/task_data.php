<?php

use App\Enum\ProjectStatus;

return [
    ["project" => "project_tasklinker", "employee" => "employee_alice", "name" => "Ajouter des tâches", "description" => "ajouter des tâches en fonction du status", "deadline" => new \DateTime('+1 month'), "status" => ProjectStatus::Todo],
    ["project" => "project_tasklinker", "employee" => "employee_rené", "name" => "Refaire la façade", "description" => "tout peinturlurer comme il faut", "deadline" => new \DateTime('+2 month'), "status" => ProjectStatus::Doing],
    ["project" => "project_tasklinker", "employee" => "employee_pierrot", "name" => "Le backend", "description" => "faut le faire", "deadline" => new \DateTime('+2 days'), "status" => ProjectStatus::Done],
    ["project" => "project_tasklinker", "employee" => "employee_pierrot", "name" => "Routage", "description" => "faire des routes", "deadline" => new \DateTime('+1 week'), "status" => ProjectStatus::Todo]
];

