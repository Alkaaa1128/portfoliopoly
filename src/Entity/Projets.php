<?php

namespace App\Entity;

use App\Repository\ProjetsRepository;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass=ProjetsRepository::class)
 */
class Projets
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lienpdf;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomprojet;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLienpdf(): ?string
    {
        return $this->lienpdf;
    }

    public function setLienpdf(string $lienpdf): self
    {
        $this->lienpdf = $lienpdf;

        return $this;
    }

    public function getNomprojet(): ?string
    {
        return $this->nomprojet;
    }

    public function setNomprojet(string $nomprojet): self
    {
        $this->nomprojet = $nomprojet;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->name);
    }
}
