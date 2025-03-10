<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Beer;

interface WriteBeerRepositoryInterface {
    public function save(Beer $beer);

    public function updateDatabase();
}
