<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\UserRepository;

/**
 * @implements ProcessorInterface<User>
 */
final readonly class CreateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $hash = password_hash($data->getPassword(), PASSWORD_DEFAULT);
        $data->setPassword($hash);

        $this->userRepository->getEntityManager()->persist($data);
        $this->userRepository->getEntityManager()->flush();

        return $data;
    }
}
