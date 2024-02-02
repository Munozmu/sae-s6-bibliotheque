<?php

namespace App\Entity;

use App\Entity\Emprunt;
use App\Entity\Reservations;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\State\UserPasswordProcessor;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use App\Repository\AdherentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ApiResource(
    formats: ['json'],
    normalizationContext: ['groups' => 'adherent'],
    denormalizationContext: ['groups' => 'adherent']
)]
#[Post(processor: UserPasswordProcessor::class)]
#[GetCollection()]
#[Get()]
#[Delete()]
#[Patch()]
#[Put()]
#[ORM\Entity(repositoryClass: AdherentRepository::class)]
class Adherent implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['adherent', 'reservation', 'emprunt', 'book'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['adherent', 'reservation', 'emprunt', 'book'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['adherent'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['adherent'])]
    private ?string $password = null;


    #[ORM\OneToMany(mappedBy: 'reserver_par', targetEntity: Reservations::class)]
    #[Groups(['adherent'])]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'adherent', targetEntity: Emprunt::class)]
    #[Assert\Count(
        min: 0,
        max: 3,
        maxMessage: 'Vous nous pouvez pas emprunter plus de 3 livres'
    )]
    #[Groups(['adherent'])]
    private Collection $emprunts;

    #[ORM\Column(length: 100)]
    #[Groups(['adherent', 'reservation', 'emprunt', 'book'])]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Groups(['adherent', 'reservation', 'emprunt', 'book'])]
    private ?string $prenom = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['adherent', 'reservation', 'emprunt', 'book'])]
    private ?\DateTimeInterface $dateNaiss = null;



    #[ORM\Column()]
    #[Groups(['adherent', 'reservation', 'emprunt'])]
    private ?string $adressePostale = null;

    #[ORM\Column(length: 20)]
    #[Groups(['adherent', 'reservation', 'emprunt', 'book'])]
    private ?string $numTel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['adherent'])]
    private ?string $photo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['adherent', 'reservation', 'emprunt'])]
    private ?\DateTimeInterface $dateAdhesion = null;

    public function __construct()
    {
        $this->dateAdhesion = new \DateTime();
        $this->reservations = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setReserverPar($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getReserverPar() === $this) {
                $reservation->setReserverPar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): static
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setAdherent($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getAdherent() === $this) {
                $emprunt->setAdherent(null);
            }
        }

        return $this;
    }

    public function __toString()
{
    return $this->nom . ' ' . $this->prenom;
}


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(\DateTimeInterface $dateNaiss): static
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getAdressePostale(): ?string
    {
        return $this->adressePostale;
    }

    public function setAdressePostale(string $adressePostale): static
    {
        $this->adressePostale = $adressePostale;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): static
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDateAdhesion(): ?\DateTimeInterface
    {
        return $this->dateAdhesion;
    }

    public function setDateAdhesion(\DateTimeInterface $dateAdhesion): static
    {
        $this->dateAdhesion = $dateAdhesion;

        return $this;
    }
}
