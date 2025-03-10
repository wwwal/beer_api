<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Infrastructure\Repository\CheckinRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckinRepository::class)]
#[ApiResource]
class Checkin
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $notation = null;

    #[ORM\ManyToOne(targetEntity: Beer::class)]
    #[ORM\JoinColumn(name: 'beer_id', referencedColumnName: 'id')]
    private Beer $beer;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotation(): ?float
    {
        return $this->notation;
    }

    public function setNotation(float $notation): static
    {
        $this->notation = $notation;

        return $this;
    }

    public function getBeer(): ?Beer
    {
        return $this->beer;
    }

    public function setBeer(?Beer $beer): static
    {
        $this->beer = $beer;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
