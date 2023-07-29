<?php

namespace App\Entity;

use App\Repository\ProprietaireTerrainCfRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProprietaireTerrainCfRepository::class)]
class ProprietaireTerrainCf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\Column(length: 50)]
    private ?string $adresse = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $cin = null;

    #[ORM\OneToMany(mappedBy: 'proprietaire', targetEntity: TerrainCf::class)]
    private Collection $terrainCfs;

    public function __construct()
    {
        $this->terrainCfs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * @return Collection<int, TerrainCf>
     */
    public function getTerrainCfs(): Collection
    {
        return $this->terrainCfs;
    }

    public function addTerrainCf(TerrainCf $terrainCf): self
    {
        if (!$this->terrainCfs->contains($terrainCf)) {
            $this->terrainCfs->add($terrainCf);
            $terrainCf->setProprietaire($this);
        }

        return $this;
    }

    public function removeTerrainCf(TerrainCf $terrainCf): self
    {
        if ($this->terrainCfs->removeElement($terrainCf)) {
            // set the owning side to null (unless already changed)
            if ($terrainCf->getProprietaire() === $this) {
                $terrainCf->setProprietaire(null);
            }
        }

        return $this;
    }
}
