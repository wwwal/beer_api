<?php

declare(strict_types=1);

namespace App\Application\Action;

use App\Domain\Entity\Beer;
use App\Domain\Entity\BeerStyle;
use App\Domain\Entity\Brewer;
use App\Domain\Repository\ReadBeerRepositoryInterface;
use App\Domain\Repository\ReadBeerStyleRepositoryInterface;
use App\Domain\Repository\ReadBrewerRepositoryInterface;
use App\Domain\Repository\WriteBeerRepositoryInterface;


class CreateBeers
{
    public function __construct(
        private ReadBeerStyleRepositoryInterface $beerStyleRepository,
        private ReadBrewerRepositoryInterface $brewerRepository,
        private ReadBeerRepositoryInterface $beerRepository,
        private WriteBeerRepositoryInterface $writeBeerRepository,
    ) {}


    public function __invoke(array $beersData): array
    {
        $beers = [];
        foreach ($beersData as $beerData) {
            $beerStyleExternalId = (int) $beerData['style_id'];
            $beerStyle = $this->beerStyleRepository->findOneByExternalId($beerStyleExternalId);
            if (null === $beerStyle) {
                $beerStyle = new BeerStyle();
            }

            $beerStyle->setExternalId($beerStyleExternalId);
            $beerStyle->setName($beerData['Style']);

            $brewerExternalId = (int) $beerData['brewery_id'];
            $brewer = $this->brewerRepository->findOneByExternalId($brewerExternalId);
            if (null === $brewer) {
                $brewer = new Brewer();
            }
            
            $brewer->setExternalId($brewerExternalId);
            $brewer->setName($beerData['Brewer']);
            $brewer->setAddress($beerData['Address']);
            $brewer->setCity($beerData['City']);
            $brewer->setCountry($beerData['Country']);

            $beerExternalId = (int) $beerData['id'];
            $beer = $this->beerRepository->findOneByExternalId($beerExternalId);
            if (null === $beer) {
                $beer = new Beer();
            }
            
            $beer->setExternalId($beerExternalId);
            $beer->setName($beerData['Name']);
            $beer->setAbv((float) $beerData['Alcohol By Volume']);
            $beer->setIbu((float) $beerData['International Bitterness Units']);
            $beer->setDescription($beerData['Description']);
            $beer->setStyle($beerStyle);
            $beer->setBrewer($brewer);

            $this->writeBeerRepository->save($beer);
        }

        $this->writeBeerRepository->updateDatabase();
        
        return $beers;
    }
}
