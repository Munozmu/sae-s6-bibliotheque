<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategorieRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    formats: ['json'],
    normalizationContext: ['groups' => ['categorie']]
)]
#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['categorie', 'book'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['categorie', 'book'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['categorie', 'book'])]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Livre::class, mappedBy: 'categories')]
    #[Groups(['categorie'])]
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
            $livre->addCategory($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): static
    {
        if ($this->livres->removeElement($livre)) {
            $livre->removeCategory($this);
        }

        return $this;
    }
}
