<?php

declare(strict_types=1);


namespace App\Infrastructure\Repository;

use App\Domain\Entity\BeerStyle;
use App\Domain\Repository\ReadBeerStyleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BeerStyle>
 */
class BeerStyleRepository extends ServiceEntityRepository implements ReadBeerStyleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BeerStyle::class);
    }

    public function findOneByExternalId(int $id): ?BeerStyle
    {
        return $this->findOneBy(['externalId' => $id]);
    }

    public function findOrderedByNumberOfBeers(): array
    {
        $qb = $this->createQueryBuilder('beer_style')
            ->leftJoin('beer_style.beers', 'b')
            ->addSelect('COUNT(b.id) AS HIDDEN beer_count')
            ->groupBy('beer_style.id')
            ->orderBy('beer_count', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
