<?php

namespace App\Entity;

use App\Repository\ArchiveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArchiveRepository::class)]
class Archive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $n_permis_archive = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDelivranceArchive = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDemandePermisArchive = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDemandeAlignementArchive = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAutreDossierArchive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNPermisArchive(): ?string
    {
        return $this->n_permis_archive;
    }

    public function setNPermisArchive(string $n_permis_archive): self
    {
        $this->n_permis_archive = $n_permis_archive;

        return $this;
    }

    public function getDateDelivranceArchive(): ?\DateTimeInterface
    {
        return $this->dateDelivranceArchive;
    }

    public function setDateDelivranceArchive(\DateTimeInterface $dateDelivranceArchive): self
    {
        $this->dateDelivranceArchive = $dateDelivranceArchive;

        return $this;
    }

    public function getNomDemandePermisArchive(): ?string
    {
        return $this->nomDemandePermisArchive;
    }

    public function setNomDemandePermisArchive(string $nomDemandePermisArchive): self
    {
        $this->nomDemandePermisArchive = $nomDemandePermisArchive;

        return $this;
    }

    public function getNomDemandeAlignementArchive(): ?string
    {
        return $this->nomDemandeAlignementArchive;
    }

    public function setNomDemandeAlignementArchive(string $nomDemandeAlignementArchive): self
    {
        $this->nomDemandeAlignementArchive = $nomDemandeAlignementArchive;

        return $this;
    }

    public function getNomAutreDossierArchive(): ?string
    {
        return $this->nomAutreDossierArchive;
    }

    public function setNomAutreDossierArchive(string $nomAutreDossierArchive): self
    {
        $this->nomAutreDossierArchive = $nomAutreDossierArchive;

        return $this;
    }
}
