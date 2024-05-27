<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GamesRepository::class)]
#[ApiResource]
class Games
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $published_date = null;

    /**
     * @var Collection<int, GameType>
     */
    #[ORM\ManyToMany(targetEntity: GameType::class, mappedBy: 'games')]
    private Collection $gameTypes;

    public function __construct()
    {
        $this->gameTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->published_date;
    }

    public function setPublishedDate(\DateTimeInterface $published_date): static
    {
        $this->published_date = $published_date;

        return $this;
    }

    /**
     * @return Collection<int, GameType>
     */
    public function getGameTypes(): Collection
    {
        return $this->gameTypes;
    }

    public function addGameType(GameType $gameType): static
    {
        if (!$this->gameTypes->contains($gameType)) {
            $this->gameTypes->add($gameType);
            $gameType->addGame($this);
        }

        return $this;
    }

    public function removeGameType(GameType $gameType): static
    {
        if ($this->gameTypes->removeElement($gameType)) {
            $gameType->removeGame($this);
        }

        return $this;
    }
}
