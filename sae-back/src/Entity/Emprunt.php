<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\EventListener\EmpruntNotifier;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping\EntityListeners;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    formats: ['json'],
    normalizationContext: ['groups' => ['emprunt']]
)]
#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
#[ORM\EntityListeners([EmpruntNotifier::class])]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['emprunt', 'adherent', 'book'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['emprunt', 'adherent', 'book'])]
    private ?\DateTimeInterface $dateEmprunt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['emprunt', 'adherent', 'book'])]
    private ?\DateTimeInterface $dateRetour = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[Groups(['emprunt', 'adherent'])]
    private ?Livre $correspondre = null;


    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[Groups(['emprunt', 'book'])]
    private ?Adherent $adherent = null;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?\DateTimeInterface
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeInterface $dateEmprunt): static
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->dateRetour;
    }

    public function setDateRetour(\DateTimeInterface $dateRetour): static
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getCorrespondre(): ?Livre
    {
        return $this->correspondre;
    }

    public function setCorrespondre(?Livre $correspondre): static
    {
        $this->correspondre = $correspondre;



        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): static
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function __toString()
    {
        return $this->dateEmprunt + $this->dateRetour;
    }
}
