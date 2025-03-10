<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Beer;

interface ReadBeerRepositoryInterface {
    public function findOneByExternalId(int $id): ?Beer;
}
