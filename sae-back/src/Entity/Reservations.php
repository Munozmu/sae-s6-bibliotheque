<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReservationsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    formats: ['json'],
    normalizationContext: ['groups' => ['reservation']]
)]
#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reservation', 'adherent'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['reservation', 'adherent'])]
    private ?\DateTimeInterface $dateResa = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['reservation', 'adherent'])]
    private ?Livre $livre = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation'])]
    private ?Adherent $adherent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateResa(): ?\DateTimeInterface
    {
        return $this->dateResa;
    }

    public function setDateResa(\DateTimeInterface $dateResa): static
    {
        $this->dateResa = $dateResa;

        return $this;
    }

    public function getLier(): ?Livre
    {
        return $this->livre;
    }

    public function setLier(?Livre $livre): static
    {
        $this->livre = $livre;

        return $this;
    }

    public function getReserverPar(): ?Adherent
    {
        return $this->adherent;
    }

    public function setReserverPar(?Adherent $adherent): static
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function __toString()
    {
        return $this->dateResa;
    }
}
