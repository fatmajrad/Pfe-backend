<?php

namespace App\Entity;

use App\Repository\ConnaissanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConnaissanceRepository::class)
 */
class Connaissance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenuConnaissance;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $imageConnaissance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenuConnaissance(): ?string
    {
        return $this->contenuConnaissance;
    }

    public function setContenuConnaissance(?string $contenuConnaissance): self
    {
        $this->contenuConnaissance = $contenuConnaissance;

        return $this;
    }

    public function getImageConnaissance()
    {
        return $this->imageConnaissance;
    }

    public function setImageConnaissance($imageConnaissance): self
    {
        $this->imageConnaissance = $imageConnaissance;

        return $this;
    }
}
