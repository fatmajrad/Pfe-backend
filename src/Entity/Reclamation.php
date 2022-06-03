<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * 
 * @ApiResource(
 *     normalizationContext={"groups"={"reclamation:read"}},
 *     denormalizationContext={"groups"={"reclamation:write"}},
 *     collectionOperations={"get","post"},
 *     itemOperations={"put","delete","get",
 *     "answerREclamtion"={
 *          "method"="Put",
 *          "path"="/reclamations/{id}/answer",
 *          "controller"=App\Controller\RespondToReclamationController::class,
 *
 *     }}
 * )
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 * 
 */
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reclamation:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"reclamation:read","reclamation:write"})
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"reclamation:read","reclamation:write"})
     */
    private $UserEmail;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"reclamation:read","reclamation:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"reclamation:read","reclamation:write"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"reclamation:read","reclamation:write"})
     */
    private $answredAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"reclamation:read","reclamation:write"})
     */
    private $statut;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"reclamation:read","reclamation:write"})
     */
    private $answer;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->statut= "onHold";
    }  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->UserEmail;
    }

    public function setUserEmail(?string $UserEmail): self
    {
        $this->UserEmail = $UserEmail;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAnswredAt(): ?\DateTimeInterface
    {
        return $this->answredAt;
    }

    public function setAnswredAt(?\DateTimeInterface $answredAt): self
    {
        $this->answredAt = $answredAt;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
