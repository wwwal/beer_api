<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Domain\Repository\ReadBeerStyleRepositoryInterface;


class GetStylesByNumberOfBeers
{
    public function __construct(
        private ReadBeerStyleRepositoryInterface $beerStyleRepository
    ) {}


    public function __invoke(): array
    {
        $beerStyles = $this->beerStyleRepository->findOrderedByNumberOfBeers();
        
        return $beerStyles;
    }
}
