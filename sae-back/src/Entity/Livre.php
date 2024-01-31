<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    formats: ['json'],
    normalizationContext: ['groups' => ['book']]
)]
#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['book', 'reservation', 'emprunt', 'auteur', 'categorie'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book', 'reservation', 'emprunt', 'auteur', 'categorie'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['book', 'reservation', 'emprunt', 'auteur', 'categorie'])]
    private ?\DateTimeInterface $dateSortie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book', 'reservation', 'emprunt', 'auteur', 'categorie'])]
    private ?string $langue = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book', 'reservation', 'emprunt'])]
    private ?string $photoCouverture = null;

    #[ORM\OneToMany(mappedBy: 'correspondre', targetEntity: Emprunt::class)]
    #[Groups(['book'])]
    private Collection $emprunts;


    #[ORM\ManyToMany(targetEntity: Auteur::class, mappedBy: 'livres')]
    #[Groups(['book'])]
    private Collection $auteurs;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'livres')]
    #[Groups(['book'])]
    private Collection $categories;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->auteurs = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): static
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): static
    {
        $this->langue = $langue;

        return $this;
    }

    public function getPhotoCouverture(): ?string
    {
        return $this->photoCouverture;
    }

    public function setPhotoCouverture(string $photoCouverture): static
    {
        $this->photoCouverture = $photoCouverture;

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
            $emprunt->setCorrespondre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getCorrespondre() === $this) {
                $emprunt->setCorrespondre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
            $auteur->addLivre($this);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        if ($this->auteurs->removeElement($auteur)) {
            $auteur->removeLivre($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
