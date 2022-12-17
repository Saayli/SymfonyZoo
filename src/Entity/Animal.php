<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 14)]
    private ?string $NumId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateArrivee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateDepart = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Proprietaire = null;

    #[ORM\Column]
    private ?bool $Genre = null;

    #[ORM\Column(length: 255)]
    private ?string $Espece = null;

    #[ORM\Column]
    private ?bool $Sterelise = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Quarantaine = null;

    #[ORM\ManyToOne(inversedBy: 'Animaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enclos $Enclo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumId(): ?string
    {
        return $this->NumId;
    }

    public function setNumId(string $NumId): self
    {
        $this->NumId = $NumId;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->DateArrivee;
    }

    public function setDateArrivee(\DateTimeInterface $DateArrivee): self
    {
        $this->DateArrivee = $DateArrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->DateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $DateDepart): self
    {
        $this->DateDepart = $DateDepart;

        return $this;
    }

    public function isProprietaire(): ?bool
    {
        return $this->Proprietaire;
    }

    public function setProprietaire(?bool $Proprietaire): self
    {
        $this->Proprietaire = $Proprietaire;

        return $this;
    }

    public function isGenre(): ?bool
    {
        return $this->Genre;
    }

    public function setGenre(bool $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->Espece;
    }

    public function setEspece(string $Espece): self
    {
        $this->Espece = $Espece;

        return $this;
    }

    public function isSterelise(): ?bool
    {
        return $this->Sterelise;
    }

    public function setSterelise(bool $Sterelise): self
    {
        $this->Sterelise = $Sterelise;

        return $this;
    }

    public function isQuarantaine(): ?bool
    {
        return $this->Quarantaine;
    }

    public function setQuarantaine(?bool $Quarantaine): self
    {
        $this->Quarantaine = $Quarantaine;

        return $this;
    }

    public function getEnclo(): ?Enclos
    {
        return $this->Enclo;
    }

    public function setEnclo(?Enclos $Enclo): self
    {
        $this->Enclo = $Enclo;

        return $this;
    }
}
