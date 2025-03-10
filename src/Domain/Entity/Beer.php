<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Infrastructure\ApiPlatform\State\Provider\BeersByScoreProvider;
use App\Infrastructure\Repository\BeerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BeerRepository::class)]
#[ORM\Index(name: "external_id_idx", columns: ["external_id"])]
#[ApiResource(
    operations: [
        // queries
        new GetCollection(
            '/beers_by_score',
            paginationEnabled: false,
            provider: BeersByScoreProvider::class,
        ),

        // crud
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
class Beer
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: true, readable: true, writable: false)]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\Column]
    #[ApiProperty(readable: false, writable: true)]
    private ?int $externalId = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(groups: ['create'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull(groups: ['create'])]
    #[Groups('read', 'write')]
    private ?float $abv = null;

    #[ORM\Column]
    #[Assert\NotNull(groups: ['create'])]
    #[Groups('read', 'write')]
    private ?float $ibu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('read', 'write')]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: BeerStyle::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'style_id', referencedColumnName: 'id', nullable: true)]
    #[ApiProperty(readableLink: false, writableLink: false)]
    private BeerStyle|null $style = null;

    #[ORM\ManyToOne(targetEntity: Brewer::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'brewer_id', referencedColumnName: 'id', nullable: true)]
    private Brewer|null $brewer = null;
    
    #[ORM\OneToMany(targetEntity: Checkin::class, mappedBy: 'beer', cascade:['remove'])]
    #[ApiProperty(writable: false)]
    private Collection $checkin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAbv(): ?float
    {
        return $this->abv;
    }

    public function setAbv(float $abv): static
    {
        $this->abv = $abv;

        return $this;
    }

    public function getIbu(): ?float
    {
        return $this->ibu;
    }

    public function setIbu(float $ibu): static
    {
        $this->ibu = $ibu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStyle(): ?BeerStyle
    {
        return $this->style;
    }

    public function setStyle(?BeerStyle $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getBrewer(): ?Brewer
    {
        return $this->brewer;
    }

    public function setBrewer(?Brewer $brewer): static
    {
        $this->brewer = $brewer;

        return $this;
    }

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }
}
