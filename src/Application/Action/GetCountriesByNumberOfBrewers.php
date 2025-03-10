<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Domain\Repository\ReadBrewerRepositoryInterface;


class GetCountriesByNumberOfBrewers
{
    public function __construct(
        private ReadBrewerRepositoryInterface $brewerRepository
    ) {}


    public function __invoke(): array
    {
        $countries = $this->brewerRepository->findCountriesByNumberOfBrewers();
        
        return $countries;
    }
}
