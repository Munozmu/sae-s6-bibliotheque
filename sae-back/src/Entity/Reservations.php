<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\EventListener\ReservationNotifier;
use App\Repository\ReservationsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    formats: ['json'],
    normalizationContext: ['groups' => ['reservation']]
)]
#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
#[ORM\EntityListeners([ReservationNotifier::class])]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reservation', 'adherent', 'book'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['reservation', 'adherent', 'book'])]
    private ?\DateTimeInterface $dateResa = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation', 'book'])]
    private ?Adherent $reserver_par = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation', 'adherent'])]
    private ?Livre $lier = null;

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

    public function getReserverPar(): ?Adherent
    {
        return $this->reserver_par;
    }

    public function setReserverPar(?Adherent $reserver_par): static
    {
        $this->reserver_par = $reserver_par;

        return $this;
    }

    public function __toString()
    {
        return $this->dateResa;
    }

    public function getLier(): ?Livre
    {
        return $this->lier;
    }

    public function setLier(?Livre $lier): static
    {
        $this->lier = $lier;

        return $this;
    }
}
