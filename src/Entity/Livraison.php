<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\OneToMany(targetEntity: Livreur::class, mappedBy: 'livraison')]
    public Collection $Livreur;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    public ?\DateTimeInterface $date_livraison = null;

    #[ORM\Column(nullable: true)]
    public ?float $prix_livraison = null;

    #[ORM\Column(length: 255)]
    private ?string $produit = null;

    public function __construct()
    {
        $this->Livreur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Livreur>
     */
    public function getLivreur(): Collection
    {
        return $this->Livreur;
    }

    public function addLivreur(Livreur $Livreur): static
    {
        if (!$this->Livreur->contains($Livreur)) {
            $this->Livreur->add($Livreur);
            $Livreur->setLivraison($this);
        }

        return $this;
    }

    public function removeLivreur(Livreur $Livreur): static
    {
        if ($this->Livreur->removeElement($Livreur)) {
            // set the owning side to null (unless already changed)
            if ($Livreur->getLivraison() === $this) {
                $Livreur->setLivraison(null);
            }
        }

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(\DateTimeInterface $date_livraison): static
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    public function getPrixLivraison(): ?float
    {
        return $this->prix_livraison;
    }

    public function setPrixLivraison(?float $prix_livraison): static
    {
        $this->prix_livraison = $prix_livraison;

        return $this;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): static
    {
        $this->produit = $produit;

        return $this;
    }
}
