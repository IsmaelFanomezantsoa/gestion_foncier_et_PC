<?php

namespace App\Entity;

use App\Repository\TerrainCadastreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerrainCadastreRepository::class)]
class TerrainCadastre
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

    #[ORM\Column(length: 50)]
    private ?string $nomCadastre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $nbParcelle = null;

    #[ORM\OneToMany(mappedBy: 'TerrainCadastre', targetEntity: Parcelle::class)]
    private Collection $parcelles;

    public function __construct()
    {
        $this->parcelles = new ArrayCollection();
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

    public function getNomCadastre(): ?string
    {
        return $this->nomCadastre;
    }

    public function setNomCadastre(string $nomCadastre): self
    {
        $this->nomCadastre = $nomCadastre;

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

    public function getNbParcelle(): ?int
    {
        return $this->nbParcelle;
    }

    public function setNbParcelle(int $nbParcelle): self
    {
        $this->nbParcelle = $nbParcelle;

        return $this;
    }

    /**
     * @return Collection<int, Parcelle>
     */
    public function getParcelles(): Collection
    {
        return $this->parcelles;
    }

    public function addParcelle(Parcelle $parcelle): self
    {
        if (!$this->parcelles->contains($parcelle)) {
            $this->parcelles->add($parcelle);
            $parcelle->setTerrainCadastre($this);
        }

        return $this;
    }

    public function removeParcelle(Parcelle $parcelle): self
    {
        if ($this->parcelles->removeElement($parcelle)) {
            // set the owning side to null (unless already changed)
            if ($parcelle->getTerrainCadastre() === $this) {
                $parcelle->setTerrainCadastre(null);
            }
        }

        return $this;
    }
}
