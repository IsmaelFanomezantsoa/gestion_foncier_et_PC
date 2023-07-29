<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenuMessage = null;

    #[ORM\Column(length: 100)]
    private ?string $typeMessage = null;

    #[ORM\Column]
    private ?bool $messageChecked = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenuMessage(): ?string
    {
        return $this->contenuMessage;
    }

    public function setContenuMessage(string $contenuMessage): self
    {
        $this->contenuMessage = $contenuMessage;

        return $this;
    }

    public function getTypeMessage(): ?string
    {
        return $this->typeMessage;
    }

    public function setTypeMessage(string $typeMessage): self
    {
        $this->typeMessage = $typeMessage;

        return $this;
    }

    public function isMessageChecked(): ?bool
    {
        return $this->messageChecked;
    }

    public function setMessageChecked(bool $messageChecked): self
    {
        $this->messageChecked = $messageChecked;

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
