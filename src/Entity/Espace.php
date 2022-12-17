<?php

namespace App\Entity;

use App\Repository\EspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspaceRepository::class)]
class Espace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $Nom = null;

    #[ORM\Column]
    private ?int $Superficie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateOuverture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateFermeture = null;

    #[ORM\OneToMany(mappedBy: 'Espace', targetEntity: Enclos::class, orphanRemoval: true)]
    private Collection $Enclos;

    public function __construct()
    {
        $this->Enclos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
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

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->DateOuverture;
    }

    public function setDateOuverture(?\DateTimeInterface $DateOuverture): self
    {
        $this->DateOuverture = $DateOuverture;

        return $this;
    }

    public function getDateFermeture(): ?\DateTimeInterface
    {
        return $this->DateFermeture;
    }

    public function setDateFermeture(?\DateTimeInterface $DateFermeture): self
    {
        $this->DateFermeture = $DateFermeture;

        return $this;
    }

    /**
     * @return Collection<int, Enclos>
     */
    public function getEnclos(): Collection
    {
        return $this->Enclos;
    }

    public function addEnclo(Enclos $enclo): self
    {
        if (!$this->Enclos->contains($enclo)) {
            $this->Enclos->add($enclo);
            $enclo->setEspace($this);
        }

        return $this;
    }

    public function removeEnclo(Enclos $enclo): self
    {
        if ($this->Enclos->removeElement($enclo)) {
            // set the owning side to null (unless already changed)
            if ($enclo->getEspace() === $this) {
                $enclo->setEspace(null);
            }
        }

        return $this;
    }
}
