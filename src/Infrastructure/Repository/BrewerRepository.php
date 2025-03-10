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

    public function findCountriesByNumberOfBrewers(): array
    {
        $qb = $this->createQueryBuilder('b')
            ->select('b.country, COUNT(b.id) AS brewer_count')
            ->groupBy('b.country')
            ->orderBy('brewer_count', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
