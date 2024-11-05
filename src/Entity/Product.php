<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "Le nom est requis.")]
    #[Assert\Length(
        max: 30,
        maxMessage: "Le nom ne doit pas dépasser 30 caractères."
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L}\s\-]+$/u',
        message: "the name must be string"
    )]
    private ?string $name_p = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description est requise.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "La description ne doit pas dépasser 255 caractères."
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L}\s\-]+$/u',
        message: "the description must be string"
    )]
    private ?string $description_p = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le prix est requis.")]
    #[Assert\Positive(message: "Le prix doit être positif.")]
    #[Assert\Regex(
        pattern: '/^-?\d+(\.\d+)?$/',
        message: "the price must be intiger"
    )]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La quantité est requise.")]
    #[Assert\Positive(message: "La quantité doit être positive.")]
    #[Assert\Regex(
        pattern: '/^-?\d+$/',
        message: "the price must be intiger"
    )]
    private ?int $qte_p = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameP(): ?string
    {
        return $this->name_p;
    }

    public function setNameP(string $name_p): static
    {
        $this->name_p = $name_p;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->description_p;
    }

    public function setDescriptionP(string $description_p): static
    {
        $this->description_p = $description_p;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQteP(): ?int
    {
        return $this->qte_p;
    }

    public function setQteP(int $qte_p): static
    {
        $this->qte_p = $qte_p;

        return $this;
    }
}
