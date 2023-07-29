<?php

namespace App\Entity;

use App\Repository\TerrainCfRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerrainCfRepository::class)]
class TerrainCf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $n_certificat = null;

    #[ORM\Column(length: 50)]
    private ?string $fkt = null;

    #[ORM\Column(length: 20)]
    private ?string $zonePudi = null;

    #[ORM\Column(length: 255)]
    private ?string $superficie = null;

    #[ORM\Column(length: 100)]
    private ?string $nomTerrainCf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'terrainCfs')]
    private ?ProprietaireTerrainCf $proprietaire = null;

    #[ORM\OneToMany(mappedBy: 'terrainCf', targetEntity: Contenance::class)]
    private Collection $contenances;

    public function __construct()
    {
        $this->contenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNCertificat(): ?string
    {
        return $this->n_certificat;
    }

    public function setNCertificat(string $n_certificat): self
    {
        $this->n_certificat = $n_certificat;

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

    public function getNomTerrainCf(): ?string
    {
        return $this->nomTerrainCf;
    }

    public function setNomTerrainCf(string $nomTerrainCf): self
    {
        $this->nomTerrainCf = $nomTerrainCf;

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

    public function getProprietaire(): ?ProprietaireTerrainCf
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?ProprietaireTerrainCf $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

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
            $contenance->setTerrainCf($this);
        }

        return $this;
    }

    public function removeContenance(Contenance $contenance): self
    {
        if ($this->contenances->removeElement($contenance)) {
            // set the owning side to null (unless already changed)
            if ($contenance->getTerrainCf() === $this) {
                $contenance->setTerrainCf(null);
            }
        }

        return $this;
    }
}
