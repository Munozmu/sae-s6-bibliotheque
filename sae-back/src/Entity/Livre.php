<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreRepository;
use ApiPlatform\Metadata\ApiResource;
use App\EventListener\LivreNotifier;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    formats: ['json'],
    normalizationContext: ['groups' => ['book']]
)]
#[ORM\Entity(repositoryClass: LivreRepository::class)]
#[ORM\EntityListeners([LivreNotifier::class])]
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
    #[Assert\Count(
        min: 1,
        max: 3,
        maxMessage: 'Un livre ne peut pas appartenir à plus de 3 Catégories'
    )]
    private Collection $categories;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['book'])]
    private ?string $resume = null;

    #[ORM\OneToMany(mappedBy: 'lier', targetEntity: Reservations::class)]
    #[Groups(['book'])]
    private Collection $reservations;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->auteurs = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->reservations = new ArrayCollection();
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

    public function __toString()
    {
        return $this->titre;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
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
            $reservation->setLier($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getLier() === $this) {
                $reservation->setLier(null);
            }
        }

        return $this;
    }
  
    public function toString()
    {
        return $this->auteurs;
    }
}
