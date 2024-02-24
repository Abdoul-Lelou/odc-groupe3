<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
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
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=Park::class, inversedBy="places")
     */
    private $park;

    /**
     * @ORM\OneToOne(targetEntity=Stationnement::class, mappedBy="place", cascade={"persist", "remove"})
     */
    private $stationnement;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDisponible;

    public function __construct()
    {
        $this->isDisponible = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPark(): ?Park
    {
        return $this->park;
    }

    public function setPark(?Park $park): self
    {
        $this->park = $park;

        return $this;
    }

    public function getStationnement(): ?Stationnement
    {
        return $this->stationnement;
    }

    public function setStationnement(Stationnement $stationnement): self
    {
        // set the owning side of the relation if necessary
        if ($stationnement->getPlace() !== $this) {
            $stationnement->setPlace($this);
        }

        $this->stationnement = $stationnement;

        return $this;
    }

    public function isIsDisponible(): ?bool
    {
        return $this->isDisponible;
    }

    public function setIsDisponible(bool $isDisponible): self
    {
        $this->isDisponible = $isDisponible;

        return $this;
    }

    public function __toString()
    {
        return $this->code;
    }
}
