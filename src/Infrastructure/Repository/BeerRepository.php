<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Beer;
use App\Domain\Repository\ReadBeerRepositoryInterface;
use App\Domain\Repository\WriteBeerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Beer>
 */
class BeerRepository extends ServiceEntityRepository implements ReadBeerRepositoryInterface, WriteBeerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    public function findOneByExternalId(int $id): ?Beer
    {
        return $this->findOneBy(['externalId' => $id]);
    }

    public function save(Beer $beer)
    {
        $this->getEntityManager()->persist($beer);
    }

    public function updateDatabase()
    {
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }
}
