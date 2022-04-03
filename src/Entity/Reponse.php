<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $decriptionReponse;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $imageCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $codeFragment;

    /**
     * @ORM\ManyToMany(targetEntity=user::class, inversedBy="votes")
     */
    private $Vote;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=user::class, inversedBy="commentaires")
     */
    private $commentaire;

    public function __construct()
    {
        $this->Vote = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDecriptionReponse(): ?string
    {
        return $this->decriptionReponse;
    }

    public function setDecriptionReponse(string $decriptionReponse): self
    {
        $this->decriptionReponse = $decriptionReponse;

        return $this;
    }

    public function getImageCode()
    {
        return $this->imageCode;
    }

    public function setImageCode($imageCode): self
    {
        $this->imageCode = $imageCode;

        return $this;
    }

    public function getCodeFragment(): ?string
    {
        return $this->codeFragment;
    }

    public function setCodeFragment(?string $codeFragment): self
    {
        $this->codeFragment = $codeFragment;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getVote(): Collection
    {
        return $this->Vote;
    }

    public function addVote(user $vote): self
    {
        if (!$this->Vote->contains($vote)) {
            $this->Vote[] = $vote;
        }

        return $this;
    }

    public function removeVote(user $vote): self
    {
        $this->Vote->removeElement($vote);

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(user $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
        }

        return $this;
    }

    public function removeCommentaire(user $commentaire): self
    {
        $this->commentaire->removeElement($commentaire);

        return $this;
    }
}
