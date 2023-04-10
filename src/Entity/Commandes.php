<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ts_commandes')]
#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'commande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?IsInCommande $panier = null;

    #[ORM\OneToMany(mappedBy: 'commandes', targetEntity: Users::class)]
    private Collection $client;

    #[ORM\Column]
    private ?bool $isFinish = null;

    public function __construct()
    {
        $this->panier = new ArrayCollection();
        $this->isFinish = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPanier(): ?IsInCommande
    {
        return $this->panier;
    }

    public function setPanier(?IsInCommande $panier): self
    {
        $this->panier = $panier;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Users $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client->add($client);
            $client->setCommandes($this);
        }

        return $this;
    }

    public function removeClient(Users $client): self
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getCommandes() === $this) {
                $client->setCommandes(null);
            }
        }

        return $this;
    }

    public function isIsFinish(): ?bool
    {
        return $this->isFinish;
    }

    public function setIsFinish(bool $isFinish): self
    {
        $this->isFinish = $isFinish;

        return $this;
    }
}
