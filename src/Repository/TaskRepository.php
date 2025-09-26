<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findByTaskOrderByStatus(Project $project): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.project = :project')
            ->setParameter('project', $project)
            ->addSelect(
                "CASE
                WHEN t.status = 'todo' THEN 1
                WHEN t.status = 'doing' THEN 2
                WHEN t.status = 'done' THEN 3
                ELSE 4
             END AS HIDDEN statusOrder"
            )
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Task[] Returns an array of Task objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Task
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
