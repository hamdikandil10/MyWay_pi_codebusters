<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue] 
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'etablissements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $trajet = null;

    #[Assert\NotNull(message:"Veuillez saisir ce champ")]
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(?Trajet $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
