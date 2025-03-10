<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Action\GetBeersByBiterness;

/**
 * @implements ProviderInterface<Beer>
 */
final readonly class BeersByBiternessProvider implements ProviderInterface
{

    public function __construct(private GetBeersByBiterness $getBeersByBiterness)
    {
    }

    /**
     * @return list<Beer>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return ($this->getBeersByBiterness)();
    }
}