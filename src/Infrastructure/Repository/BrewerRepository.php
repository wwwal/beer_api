<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Brewer;
use App\Domain\Repository\ReadBrewerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Brewer>
 */
class BrewerRepository extends ServiceEntityRepository implements ReadBrewerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brewer::class);
    }

    public function findOneByExternalId(int $id): ?Brewer
    {
        return $this->findOneBy(['externalId' => $id]);
    }
}
