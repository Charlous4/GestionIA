<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $priorite = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Version $version = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Ingenieur $ingenieur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isPriorite(): ?bool
    {
        return $this->priorite;
    }

    public function setPriorite(bool $priorite): static
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getVersion(): ?Version
    {
        return $this->version;
    }

    public function setVersion(?Version $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getIngenieur(): ?Ingenieur
    {
        return $this->ingenieur;
    }

    public function setIngenieur(?Ingenieur $ingenieur): static
    {
        $this->ingenieur = $ingenieur;

        return $this;
    }
}
