<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Action\GetStylesByNumberOfBeers;
use App\Domain\Entity\BeerStyle;

/**
 * @implements ProviderInterface<BeerStyle>
 */
final readonly class BeerStylesByNumberOfBeersProvider implements ProviderInterface
{

    public function __construct(private GetStylesByNumberOfBeers $getStylesByNumberOfBeers)
    {
    }

    /**
     * @return list<BeerStyle>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return ($this->getStylesByNumberOfBeers)();
    }
}