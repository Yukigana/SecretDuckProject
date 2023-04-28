<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Table(name: 'ts_produit')]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 255,
        maxMessage: 'La taille du nom est trop grande ; la limite est {{ limit }}',
    )]
    private ?string $libelle = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Range(
        notInRangeMessage: 'le prix doit être supérieur à {{ min }}',
        min: 0.01,
    )]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Range(
        notInRangeMessage: 'la quantité doit être supérieur à {{ min }}',
        min: 0,
    )]
    private ?int $quantite = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: IsInCommande::class)]
    #[Assert\Valid]
    private Collection $panier;

    /**
     * Constructeur UseProduit
     */
    public function __construct(){
        $this->panier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
