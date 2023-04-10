<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ts_users')]
#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 20,
        maxMessage: 'La taille du login est trop grande ; la limite est {{ limit }}',
    )]
    private ?string $login = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 50,
        min: 5,
        maxMessage: 'La taille du mdp doit être comprise entre {{ min }} et {{ max }}',
    )]
    private ?string $mdp = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 20,
        maxMessage: 'La taille du nom est trop grande ; la limite est {{ limit }}',
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 20,
        maxMessage: 'La taille du prenom est trop grande ; la limite est {{ limit }}',
    )]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Range(
        minMessage: 'la doyenne de l\'huanité est née après {{ limit }}',
        min: 1905,
    )]
    #[Assert\Range(
        maxMessage: '{{ value }} est trop loin dans le futur, après {{ limit }} ...',
        max: 2040,
    )]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\ManyToOne(inversedBy: 'client')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commandes $commandes = null;

    #[ORM\Column]
    private ?bool $isAdmin = null;

    #[ORM\Column]
    private ?bool $isSuperAdmin = null;

    /**
     * Constructeur Users
     */
    public function __construct(){
        $this->commandes = new ArrayCollection();
        $this->isAdmin = false;
        $this->isSuperAdmin = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getCommandes(): ?Commandes
    {
        return $this->commandes;
    }

    public function setCommandes(?Commandes $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }

    public function isIsSuperAdmin(): ?bool
    {
        return $this->isSuperAdmin;
    }

    public function setIsSuperAdmin(bool $isSuperAdmin): self
    {
        $this->isSuperAdmin = $isSuperAdmin;

        return $this;
    }
}
