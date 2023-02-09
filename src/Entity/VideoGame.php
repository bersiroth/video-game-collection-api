<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VideoGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: VideoGameRepository::class)]
class VideoGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Ignore]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    #[SerializedName('id')]
    private UuidInterface|string|null $uuid = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\ManyToMany(targetEntity: Genre::class)]
    private Collection $genre;

    #[ORM\ManyToMany(targetEntity: Platform::class)]
    private Collection $platform;

    #[ORM\ManyToMany(targetEntity: Developer::class)]
    private Collection $developer;

    #[ORM\ManyToMany(targetEntity: Franchise::class)]
    private Collection $franchise;

    #[ORM\ManyToMany(targetEntity: Publisher::class)]
    private Collection $publisher;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
        $this->platform = new ArrayCollection();
        $this->developer = new ArrayCollection();
        $this->franchise = new ArrayCollection();
        $this->publisher = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface|string|null
    {
        return $this->uuid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Platform>
     */
    public function getPlatform(): Collection
    {
        return $this->platform;
    }

    public function addPlatform(Platform $platform): self
    {
        if (!$this->platform->contains($platform)) {
            $this->platform->add($platform);
        }

        return $this;
    }

    public function removePlatform(Platform $platform): self
    {
        $this->platform->removeElement($platform);

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getDeveloper(): Collection
    {
        return $this->developer;
    }

    public function addDeveloper(Developer $developer): self
    {
        if (!$this->developer->contains($developer)) {
            $this->developer->add($developer);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): self
    {
        $this->developer->removeElement($developer);

        return $this;
    }

    /**
     * @return Collection<int, Franchise>
     */
    public function getFranchise(): Collection
    {
        return $this->franchise;
    }

    public function addFranchise(Franchise $franchise): self
    {
        if (!$this->franchise->contains($franchise)) {
            $this->franchise->add($franchise);
        }

        return $this;
    }

    public function removeFranchise(Franchise $franchise): self
    {
        $this->franchise->removeElement($franchise);

        return $this;
    }

    /**
     * @return Collection<int, Publisher>
     */
    public function getPublisher(): Collection
    {
        return $this->publisher;
    }

    public function addPublisher(Publisher $publisher): self
    {
        if (!$this->publisher->contains($publisher)) {
            $this->publisher->add($publisher);
        }

        return $this;
    }

    public function removePublisher(Publisher $publisher): self
    {
        $this->publisher->removeElement($publisher);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setUuid(UuidInterface|string|null $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function setName(?string $name): VideoGame
    {
        $this->name = $name;

        return $this;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): VideoGame
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function setDescription(?string $description): VideoGame
    {
        $this->description = $description;

        return $this;
    }
}
