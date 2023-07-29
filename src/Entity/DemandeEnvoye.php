<?php

namespace App\Entity;

use App\Repository\DemandeEnvoyeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeEnvoyeRepository::class)]
class DemandeEnvoye
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDemandePc = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDemandeAlignement = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAutreDossier = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoie = null;

    #[ORM\ManyToOne(inversedBy: 'demandeEnvoyes')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDemandePc(): ?string
    {
        return $this->nomDemandePc;
    }

    public function setNomDemandePc(string $nomDemandePc): self
    {
        $this->nomDemandePc = $nomDemandePc;

        return $this;
    }

    public function getNomDemandeAlignement(): ?string
    {
        return $this->nomDemandeAlignement;
    }

    public function setNomDemandeAlignement(string $nomDemandeAlignement): self
    {
        $this->nomDemandeAlignement = $nomDemandeAlignement;

        return $this;
    }

    public function getNomAutreDossier(): ?string
    {
        return $this->nomAutreDossier;
    }

    public function setNomAutreDossier(string $nomAutreDossier): self
    {
        $this->nomAutreDossier = $nomAutreDossier;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): self
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
