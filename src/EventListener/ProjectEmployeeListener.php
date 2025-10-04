<?php

namespace App\EventListener;

use App\Entity\Project;
use App\Entity\Task;
use Doctrine\ORM\Event\OnFlushEventArgs;

class ProjectEmployeeListener
{
    public function onFlush(OnFlushEventArgs $args): void
    {
        // NOTE: getObjectManager() pour Doctrine 3 (remplace getEntityManager())
        $em  = $args->getObjectManager();
        $uow = $em->getUnitOfWork();

        // 1) Collections mises à jour (ex: ajout/suppression d'employés dans le projet)
        foreach ($uow->getScheduledCollectionUpdates() as $collection) {
            $owner   = $collection->getOwner();
            $mapping = $collection->getMapping();

            // On cible la collection "employees" du Project
            if (! $owner instanceof Project || ($mapping['fieldName'] ?? null) !== 'employees') {
                continue;
            }

            // Récupère les employés supprimés (delete diff), fallback snapshot si vide
            $removedEmployees = [];
            if (method_exists($collection, 'getDeleteDiff')) {
                $removedEmployees = $collection->getDeleteDiff() ?: [];
            }
            if (empty($removedEmployees)) {
                // getSnapshot() contient l'état avant modification
                $removedEmployees = $collection->getSnapshot() ?: [];
            }

            foreach ($removedEmployees as $removedEmployee) {
                foreach ($owner->getTasks() as $task) {
                    $taskEmployee = $task->getEmployee();
                    if ($taskEmployee && $taskEmployee->getId() === $removedEmployee->getId()) {
                        $task->setEmployee(null);
                        $em->persist($task);
                        $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(Task::class), $task);
                    }
                }
            }
        }

        // 2) Cas où la collection est supprimée complètement (rare dans un formulaire, mais safe)
        foreach ($uow->getScheduledCollectionDeletions() as $collection) {
            $owner   = $collection->getOwner();
            $mapping = $collection->getMapping();

            if (! $owner instanceof Project || ($mapping['fieldName'] ?? null) !== 'employees') {
                continue;
            }

            $snapshot = $collection->getSnapshot() ?: [];
            foreach ($snapshot as $removedEmployee) {
                foreach ($owner->getTasks() as $task) {
                    $taskEmployee = $task->getEmployee();
                    if ($taskEmployee && $taskEmployee->getId() === $removedEmployee->getId()) {
                        $task->setEmployee(null);
                        $em->persist($task);
                        $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(Task::class), $task);
                    }
                }
            }
        }
    }
}
