<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuteurRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    formats: ['json'],
    normalizationContext: ['groups' => 'auteur']
)]
#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['auteur', 'book'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['auteur', 'book'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['auteur', 'book'])]
    private ?string $prenom = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['auteur'])]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['auteur'])]
    private ?\DateTimeInterface $dateDeces = null;

    #[ORM\Column(length: 255)]
    #[Groups(['auteur', 'book'])]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255)]
    #[Groups(['auteur'])]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    #[Groups(['auteur'])]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'auteurs')]
    #[Groups(['auteur'])]
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDateDeces(): ?\DateTimeInterface
    {
        return $this->dateDeces;
    }

    public function setDateDeces(?\DateTimeInterface $dateDeces): static
    {
        $this->dateDeces = $dateDeces;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    
    public function __toString()
    {
        return $this->nom;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): static
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): static
    {
        $this->livres->removeElement($livre);

        return $this;
    }
}
