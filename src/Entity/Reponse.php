<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"reponse:read"}},
 *     denormalizationContext={"groups"={"reponse:write"}})
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reponse:read","question:read","commentaire:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"reponse:write","reponse:read","question:read"})
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"reponse:write","reponse:read","question:read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="reponses")
     * @Groups({"reponse:read","reponse:write"})
     * 
     */
    private $Question;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="reponse")
     * @Groups({"reponse:read","question:read"})
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="Reponse")
     * @Groups({"reponse:read","question:read"})
     */
    private $votes;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reponse:read","reponse:write"})
     * 
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date",nullable=true)
     * @Groups({"reponse:read","reponse:write"})
     */
    private $updatedAt;

    public function __construct()
    {   $this->createdAt = new \DateTime();
        $this->commentaires = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

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

    public function getQuestion(): ?Question
    {
        return $this->Question;
    }

    public function setQuestion(?Question $Question): self
    {
        $this->Question = $Question;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setReponse($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getReponse() === $this) {
                $commentaire->setReponse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setReponse($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getReponse() === $this) {
                $vote->setReponse(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
