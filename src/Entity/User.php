<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "le nom doit comporte min  {{ limit }} caractere",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @Groups({"user:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "le prénom doit comporte min  {{ limit }} caractere",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Length(
     *      min = 9,
     *      max = 14,
     *      minMessage = "le numero doit comporte min  {{ limit }} caractere",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity=Park::class, mappedBy="user")
     */
    private $parks;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\OneToMany(targetEntity=Stationnement::class, mappedBy="user", orphanRemoval=true)
     */
    private $stationnements;
    

    public function __construct()
    {
        $this->parks = new ArrayCollection();
        $this->stationnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function setProfile(string $profile): self
    {
        $this->profile = $profile;

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
            $park->setUser($this);
        }

        return $this;
    }

    public function removePark(Park $park): self
    {
        if ($this->parks->removeElement($park)) {
            // set the owning side to null (unless already changed)
            if ($park->getUser() === $this) {
                $park->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->firstname." ".$this->lastname;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection<int, Stationnement>
     */
    public function getStationnements(): Collection
    {
        return $this->stationnements;
    }

    public function addStationnement(Stationnement $stationnement): self
    {
        if (!$this->stationnements->contains($stationnement)) {
            $this->stationnements[] = $stationnement;
            $stationnement->setUser($this);
        }

        return $this;
    }

    public function removeStationnement(Stationnement $stationnement): self
    {
        if ($this->stationnements->removeElement($stationnement)) {
            // set the owning side to null (unless already changed)
            if ($stationnement->getUser() === $this) {
                $stationnement->setUser(null);
            }
        }

        return $this;
    }
}
