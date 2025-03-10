<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Domain\Repository\ReadBeerRepositoryInterface;


class GetBeersByBiterness
{
    public function __construct(
        private ReadBeerRepositoryInterface $beerRepository
    ) {}


    public function __invoke(): array
    {
        $beers = $this->beerRepository->findByBiterness();
        
        return $beers;
    }
}
