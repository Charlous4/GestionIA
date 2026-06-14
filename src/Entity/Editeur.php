<?php

namespace App\Entity;

use App\Repository\EditeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EditeurRepository::class)]
class Editeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, IA>
     */
    #[ORM\OneToMany(targetEntity: IA::class, mappedBy: 'editeur')]
    private Collection $iAs;

    public function __construct()
    {
        $this->iAs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, IA>
     */
    public function getIAs(): Collection
    {
        return $this->iAs;
    }

    public function addIA(IA $iA): static
    {
        if (!$this->iAs->contains($iA)) {
            $this->iAs->add($iA);
            $iA->setEditeur($this);
        }

        return $this;
    }

    public function removeIA(IA $iA): static
    {
        if ($this->iAs->removeElement($iA)) {
            // set the owning side to null (unless already changed)
            if ($iA->getEditeur() === $this) {
                $iA->setEditeur(null);
            }
        }

        return $this;
    }
}
