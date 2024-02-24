<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Park::class, mappedBy="categorie")
     */
    private $parks;

    public function __construct()
    {
        $this->parks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Park>
     */
    public function getParks(): Collection
    {
        return $this->parks;
    }

    public function addPark(Park $park): self
    {
        if (!$this->parks->contains($park)) {
            $this->parks[] = $park;
            $park->setCategorie($this);
        }

        return $this;
    }

    public function removePark(Park $park): self
    {
        if ($this->parks->removeElement($park)) {
            // set the owning side to null (unless already changed)
            if ($park->getCategorie() === $this) {
                $park->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
