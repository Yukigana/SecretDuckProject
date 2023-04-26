<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'ts_user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // - - - - - --------------------------------------------------- - - - - - //
    //                                 CHAMPS                                  //

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 20,
        maxMessage: 'La taille du login est trop grande ; la limite est {{ limit }}',
    )]
    private ?string $login = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 50,
        min: 5,
        maxMessage: 'La taille du mdp doit être comprise entre {{ min }} et {{ max }}',
    )]
    private ?string $password = null;

        // FIN DES CHAMPS PRINCIPAUX

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 20,
        maxMessage: 'La taille du prenom est trop grande ; la limite est {{ limit }}',
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 20,
        maxMessage: 'La taille du nom est trop grande ; la limite est {{ limit }}',
    )]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[Assert\Valid]
    private Collection $commandes;

    /**
     * Constructeur User
     */
    public function __construct(){
        $this->commandes = new ArrayCollection();
    }

    //                                                                         //
    // - - - - - --------------------------------------------------- - - - - - //

    // - - - - - --------------------------------------------------- - - - - - //
    //                          GETTERS / SETTERS                              //

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'NO_ROLE';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getCommandes(): ?Commande
    {
        return $this->commandes;
    }

    public function setCommandes(?Commande $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }

    //                                                                         //
    // - - - - - --------------------------------------------------- - - - - - //

    // - - - - - --------------------------------------------------- - - - - - //
    //                              FONCTIONS                                  //

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    //                                                                         //
    // - - - - - --------------------------------------------------- - - - - - //
}
