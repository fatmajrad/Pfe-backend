<?php

namespace App\Entity;

use App\Repository\ConnaissanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ConnaissanceRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"connaissance:read"}},
 *     denormalizationContext={"groups"={"connaissance:write"}},
 *     collectionOperations={"get","post",
 *     "count"={
 *           "path"="/connaissances/{statut}/count",
 *              "method"="GET",
 *              "controller" = App\Controller\CountAllConnaissancesController::class,
 *      },
 *      "countIntervall"={
 *           "path"="/connaissances/{statut}/{minDate}/{maxDate}/countdate",
 *              "method"="GET",
 *              "controller" = App\Controller\CountIntervallConnaissancesController::class,
 *     }},
 *     itemOperations={"put","delete","get"})
 * @ApiFilter(SearchFilter::class,properties={"user.id":"exact","statut":"exact","contenuConnaissance":"partial","sujet.id"="exact"})
 */
class Connaissance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"connaissance:read","commentaire:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"connaissance:read", "connaissance:write"})
     */
    private $contenuConnaissance;

    
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="connaissances")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"connaissance:read","connaissance:write"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Sujet::class, inversedBy="connaissances")
     * @Groups({"connaissance:read","connaissance:write"})
     */
    private $sujet;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="connaissance")
     * @Groups({"connaissance:read"})
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="Connaissance")
     * @Groups({"connaissance:read"})
     */
    private $votes;


    

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"connaissance:read","connaissance:write"})
     */
    private $statut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"connaissance:read","connaissance:write"})
     */
    private $createdAt;

/**
     * @ORM\Column(type="date",nullable=true)
     * @Groups({"connaissance:read","connaissance:write"})
     */
    private $updatedAt;
   
    public function __construct()
    {   $this->createdAt = new \DateTime();
        $this->sujet = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->statut="onHold";
    }

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
     * @return Collection<int, sujet>
     */
    public function getSujet(): Collection
    {
        return $this->sujet;
    }

    public function addSujet(sujet $sujet): self
    {
        if (!$this->sujet->contains($sujet)) {
            $this->sujet[] = $sujet;
        }

        return $this;
    }

    public function removeSujet(sujet $sujet): self
    {
        $this->sujet->removeElement($sujet);

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
            $commentaire->setConnaissance($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getConnaissance() === $this) {
                $commentaire->setConnaissance(null);
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
            $vote->setConnaissance($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getConnaissance() === $this) {
                $vote->setConnaissance(null);
            }
        }

        return $this;
    }

   

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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
