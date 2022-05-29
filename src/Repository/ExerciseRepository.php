<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    public function findMatchedExercises(int $lvl, array $parts)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query
            ->select('e')
            ->from(Exercise::class, 'e')
            ->where('e.lvl = :lvl')
            ->andWhere('e.part in (:parts)');

        $query->setParameter('lvl', $lvl);
        $query->setParameter('parts', $parts);

        return $query->getQuery()->getResult();
    }
}
