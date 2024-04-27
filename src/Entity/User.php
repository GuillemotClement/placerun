<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(nullable: true)]
    private ?int $fcm = null;

    /**
     * @var Collection<int, vma>
     */
    #[ORM\OneToMany(targetEntity: Vma::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $vma;

    public function __construct()
    {
        $this->vma = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }



    public function getAge()
    {
        if($this->dateOfBirth === null)
        {
            return null;
        }

        $now = new \DateTime('now');
        $age = $this->dateOfBirth->diff($now)->y;

        return $age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getFcm(): ?int
    {
        return $this->fcm;
    }

    public function setFcm(?int $fcm): static
    {
        $this->fcm = $fcm;

        return $this;
    }

    /**
     * @return Collection<int, vma>
     */
    public function getVma(): Collection
    {
        return $this->vma;
    }

    public function addVma(vma $vma): static
    {
        if (!$this->vma->contains($vma)) {
            $this->vma->add($vma);
            $vma->setUser($this);
        }

        return $this;
    }

    public function removeVma(vma $vma): static
    {
        if ($this->vma->removeElement($vma)) {
            // set the owning side to null (unless already changed)
            if ($vma->getUser() === $this) {
                $vma->setUser(null);
            }
        }

        return $this;
    }



}
