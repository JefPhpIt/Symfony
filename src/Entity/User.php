<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $genreId = null;

    #[ORM\ManyToMany(targetEntity: VideoGame::class, inversedBy: 'users')]
    private Collection $videoGames;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserVideoGameHour::class, orphanRemoval: true)]
    private Collection $userVideoGameHours;

    public function __construct()
    {
        $this->videoGames = new ArrayCollection();
        $this->userVideoGameHours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGenreId(): ?Genre
    {
        return $this->genreId;
    }

    public function setGenreId(?Genre $genreId): self
    {
        $this->genreId = $genreId;

        return $this;
    }

    /**
     * @return Collection<int, VideoGame>
     */
    public function getVideoGames(): Collection
    {
        return $this->videoGames;
    }

    public function addVideoGame(VideoGame $videoGame): self
    {
        if (!$this->videoGames->contains($videoGame)) {
            $this->videoGames->add($videoGame);
        }

        return $this;
    }

    public function removeVideoGame(VideoGame $videoGame): self
    {
        $this->videoGames->removeElement($videoGame);

        return $this;
    }

    /**
     * @return Collection<int, UserVideoGameHour>
     */
    public function getUserVideoGameHours(): Collection
    {
        return $this->userVideoGameHours;
    }

    public function addUserVideoGameHour(UserVideoGameHour $userVideoGameHour): self
    {
        if (!$this->userVideoGameHours->contains($userVideoGameHour)) {
            $this->userVideoGameHours->add($userVideoGameHour);
            $userVideoGameHour->setUser($this);
        }

        return $this;
    }

    public function removeUserVideoGameHour(UserVideoGameHour $userVideoGameHour): self
    {
        if ($this->userVideoGameHours->removeElement($userVideoGameHour)) {
            // set the owning side to null (unless already changed)
            if ($userVideoGameHour->getUser() === $this) {
                $userVideoGameHour->setUser(null);
            }
        }

        return $this;
    }
}
