<?php

namespace App\Entity;

use App\Repository\ContenanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContenanceRepository::class)]
class Contenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $usageBatimentContenance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surfaceOccupeContenance = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbContenance = null;

    #[ORM\ManyToOne(inversedBy: 'contenances')]
    private ?TerrainTitre $terrainTitre = null;

    #[ORM\ManyToOne(inversedBy: 'contenances')]
    private ?TerrainCf $terrainCf = null;

    #[ORM\ManyToOne(inversedBy: 'contenances')]
    private ?Parcelle $parcelle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsageBatimentContenance(): ?string
    {
        return $this->usageBatimentContenance;
    }

    public function setUsageBatimentContenance(?string $usageBatimentContenance): self
    {
        $this->usageBatimentContenance = $usageBatimentContenance;

        return $this;
    }

    public function getSurfaceOccupeContenance(): ?string
    {
        return $this->surfaceOccupeContenance;
    }

    public function setSurfaceOccupeContenance(?string $surfaceOccupeContenance): self
    {
        $this->surfaceOccupeContenance = $surfaceOccupeContenance;

        return $this;
    }

    public function getNbContenance(): ?int
    {
        return $this->nbContenance;
    }

    public function setNbContenance(?int $nbContenance): self
    {
        $this->nbContenance = $nbContenance;

        return $this;
    }

    public function getTerrainTitre(): ?TerrainTitre
    {
        return $this->terrainTitre;
    }

    public function setTerrainTitre(?TerrainTitre $terrainTitre): self
    {
        $this->terrainTitre = $terrainTitre;

        return $this;
    }

    public function getTerrainCf(): ?TerrainCf
    {
        return $this->terrainCf;
    }

    public function setTerrainCf(?TerrainCf $terrainCf): self
    {
        $this->terrainCf = $terrainCf;

        return $this;
    }

    public function getParcelle(): ?Parcelle
    {
        return $this->parcelle;
    }

    public function setParcelle(?Parcelle $parcelle): self
    {
        $this->parcelle = $parcelle;

        return $this;
    }
}
