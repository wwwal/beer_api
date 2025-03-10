<?php

declare(strict_types=1);

namespace App\Domain\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Infrastructure\Repository\BeerStyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiProperty;
use App\Infrastructure\ApiPlatform\State\Provider\BeerStylesByNumberOfBeersProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BeerStyleRepository::class)]
#[ORM\Index(name: "external_id_idx", columns: ["external_id"])]
#[ApiResource(
    operations: [
        // queries
        new GetCollection(
            '/beers_style_by_beers_count',
            paginationEnabled: false,
            provider: BeerStylesByNumberOfBeersProvider::class,
        ),

        // crud
        new GetCollection(
            normalizationContext: ['groups' => ['read', 'read:beer_styles:collection']],
            paginationEnabled: true
        ),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
class BeerStyle
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $externalId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:beer_styles:collection', 'read:beer_styles:single', 'write:beer_styles'])]
    private ?string $name = null;


    #[Groups('read:beer_styles:single')]
    #[ORM\OneToMany(targetEntity: Beer::class, mappedBy: 'style', orphanRemoval: true)]
    #[ApiProperty(writable: false)]
    private Collection $beers;

    public function __construct()
    {
        $this->beers = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Beer>
     */
    public function getBeers(): Collection
    {
        return $this->beers;
    }

    public function addBeer(Beer $beer): static
    {
        if (!$this->beers->contains($beer)) {
            $this->beers->add($beer);
            $beer->setStyle($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): static
    {
        if ($this->beers->removeElement($beer)) {
            // set the owning side to null (unless already changed)
            if ($beer->getStyle() === $this) {
                $beer->setStyle(null);
            }
        }

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
