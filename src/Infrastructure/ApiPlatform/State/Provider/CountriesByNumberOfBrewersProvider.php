<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Action\GetCountriesByNumberOfBrewers;

/**
 * @implements ProviderInterface
 */
final readonly class CountriesByNumberOfBrewersProvider implements ProviderInterface
{

    public function __construct(private GetCountriesByNumberOfBrewers $getCountriesByNumberOfBrewers)
    {
    }

    /**
     * @return list
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return ($this->getCountriesByNumberOfBrewers)();
    }
}