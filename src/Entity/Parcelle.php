<?php

namespace App\Entity;

use App\Repository\ParcelleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcelleRepository::class)]
class Parcelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $n_parcelle = null;

    #[ORM\Column(length: 255)]
    private ?string $superficie_parcelle = null;

    #[ORM\Column(length: 255)]
    private ?string $imageParcelle = null;

    #[ORM\ManyToOne(inversedBy: 'parcelles')]
    private ?TerrainCadastre $TerrainCadastre = null;

    #[ORM\ManyToOne(inversedBy: 'parcelles')]
    private ?ProprietaireParcelle $proprietaireParcelle = null;

    #[ORM\OneToMany(mappedBy: 'parcelle', targetEntity: Contenance::class)]
    private Collection $contenances;

    public function __construct()
    {
        $this->contenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNParcelle(): ?string
    {
        return $this->n_parcelle;
    }

    public function setNParcelle(string $n_parcelle): self
    {
        $this->n_parcelle = $n_parcelle;

        return $this;
    }

    public function getSuperficieParcelle(): ?string
    {
        return $this->superficie_parcelle;
    }

    public function setSuperficieParcelle(string $superficie_parcelle): self
    {
        $this->superficie_parcelle = $superficie_parcelle;

        return $this;
    }

    public function getImageParcelle(): ?string
    {
        return $this->imageParcelle;
    }

    public function setImageParcelle(string $imageParcelle): self
    {
        $this->imageParcelle = $imageParcelle;

        return $this;
    }

    public function getTerrainCadastre(): ?TerrainCadastre
    {
        return $this->TerrainCadastre;
    }

    public function setTerrainCadastre(?TerrainCadastre $TerrainCadastre): self
    {
        $this->TerrainCadastre = $TerrainCadastre;

        return $this;
    }

    public function getProprietaireParcelle(): ?ProprietaireParcelle
    {
        return $this->proprietaireParcelle;
    }

    public function setProprietaireParcelle(?ProprietaireParcelle $proprietaireParcelle): self
    {
        $this->proprietaireParcelle = $proprietaireParcelle;

        return $this;
    }

    /**
     * @return Collection<int, Contenance>
     */
    public function getContenances(): Collection
    {
        return $this->contenances;
    }

    public function addContenance(Contenance $contenance): self
    {
        if (!$this->contenances->contains($contenance)) {
            $this->contenances->add($contenance);
            $contenance->setParcelle($this);
        }

        return $this;
    }

    public function removeContenance(Contenance $contenance): self
    {
        if ($this->contenances->removeElement($contenance)) {
            // set the owning side to null (unless already changed)
            if ($contenance->getParcelle() === $this) {
                $contenance->setParcelle(null);
            }
        }

        return $this;
    }
}
