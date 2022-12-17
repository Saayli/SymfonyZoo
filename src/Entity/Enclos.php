<?php

namespace App\Entity;

use App\Repository\EnclosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnclosRepository::class)]
class Enclos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nom = null;

    #[ORM\Column]
    private ?int $Superficie = null;

    #[ORM\Column]
    private ?int $AnimauxMax = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Quarantaine = null;

    #[ORM\ManyToOne(inversedBy: 'Enclos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Espace $Espace = null;

    #[ORM\OneToMany(mappedBy: 'Enclo', targetEntity: Animal::class)]
    private Collection $Animaux;

    public function __construct()
    {
        $this->Animaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSuperficie(): ?int
    {
        return $this->Superficie;
    }

    public function setSuperficie(int $Superficie): self
    {
        $this->Superficie = $Superficie;

        return $this;
    }

    public function getAnimauxMax(): ?int
    {
        return $this->AnimauxMax;
    }

    public function setAnimauxMax(int $AnimauxMax): self
    {
        $this->AnimauxMax = $AnimauxMax;

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

    public function getEspace(): ?Espace
    {
        return $this->Espace;
    }

    public function setEspace(?Espace $Espace): self
    {
        $this->Espace = $Espace;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimaux(): Collection
    {
        return $this->Animaux;
    }

    public function addAnimaux(Animal $animaux): self
    {
        if (!$this->Animaux->contains($animaux)) {
            $this->Animaux->add($animaux);
            $animaux->setEnclo($this);
        }

        return $this;
    }

    public function removeAnimaux(Animal $animaux): self
    {
        if ($this->Animaux->removeElement($animaux)) {
            // set the owning side to null (unless already changed)
            if ($animaux->getEnclo() === $this) {
                $animaux->setEnclo(null);
            }
        }

        return $this;
    }
}
