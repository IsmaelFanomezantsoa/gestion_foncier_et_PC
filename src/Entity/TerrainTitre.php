<?php

namespace App\Entity;

use App\Repository\TerrainTitreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerrainTitreRepository::class)]
class TerrainTitre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $n_titre = null;

    #[ORM\Column(length: 50)]
    private ?string $fkt = null;

    #[ORM\Column(length: 20)]
    private ?string $zonePudi = null;

    #[ORM\Column(length: 255)]
    private ?string $superficie = null;

    #[ORM\Column(length: 100)]
    private ?string $nomTerrainTitre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'terrainTitres')]
    private ?ProprietaireTerrainTitre $proprietaireTerrainTitre = null;

    #[ORM\OneToMany(mappedBy: 'terrainTitre', targetEntity: Contenance::class)]
    private Collection $contenances;

    public function __construct()
    {
        $this->contenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNTitre(): ?string
    {
        return $this->n_titre;
    }

    public function setNTitre(string $n_titre): self
    {
        $this->n_titre = $n_titre;

        return $this;
    }

    public function getFkt(): ?string
    {
        return $this->fkt;
    }

    public function setFkt(string $fkt): self
    {
        $this->fkt = $fkt;

        return $this;
    }

    public function getZonePudi(): ?string
    {
        return $this->zonePudi;
    }

    public function setZonePudi(string $zonePudi): self
    {
        $this->zonePudi = $zonePudi;

        return $this;
    }

    public function getSuperficie(): ?string
    {
        return $this->superficie;
    }

    public function setSuperficie(string $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getNomTerrainTitre(): ?string
    {
        return $this->nomTerrainTitre;
    }

    public function setNomTerrainTitre(string $nomTerrainTitre): self
    {
        $this->nomTerrainTitre = $nomTerrainTitre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getProprietaireTerrainTitre(): ?ProprietaireTerrainTitre
    {
        return $this->proprietaireTerrainTitre;
    }

    public function setProprietaireTerrainTitre(?ProprietaireTerrainTitre $proprietaireTerrainTitre): self
    {
        $this->proprietaireTerrainTitre = $proprietaireTerrainTitre;

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
            $contenance->setTerrainTitre($this);
        }

        return $this;
    }

    public function removeContenance(Contenance $contenance): self
    {
        if ($this->contenances->removeElement($contenance)) {
            // set the owning side to null (unless already changed)
            if ($contenance->getTerrainTitre() === $this) {
                $contenance->setTerrainTitre(null);
            }
        }

        return $this;
    }

    
}
