<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\BeerStyle;

interface ReadBeerStyleRepositoryInterface {
    public function findOneByExternalId(int $id): ?BeerStyle;
}
