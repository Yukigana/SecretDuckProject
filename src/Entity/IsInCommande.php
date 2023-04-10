<?php

namespace App\Entity;

use App\Repository\IsInCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ts_isInCommande')]
#[ORM\Entity(repositoryClass: IsInCommandeRepository::class)]
class IsInCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: Commandes::class)]
    private Collection $commande;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * @return Collection<int, Commandes>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande->add($commande);
            $commande->setPanier($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getPanier() === $this) {
                $commande->setPanier(null);
            }
        }

        return $this;
    }
}
