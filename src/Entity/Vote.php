<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 *  @ApiResource(
 *     normalizationContext={"groups"={"vote:read"}},
 *     denormalizationContext={"groups"={"vote:write"}},
 *     collectionOperations={
 *       "get","post",
 *       "count"={
 *           "path"="/votes/{idUser}/{idConnaissance}/{idReponse}/{idQuestion}/{typeVote}/count",
 *              "method"="GET",
 *              "controller" = App\Controller\CountVoteController::class,
 *       }
 *     })
 * @ORM\Entity(repositoryClass=VoteRepository::class)
 * @ApiFilter(SearchFilter::class,properties={"user.id":"exact","Connaissance.id"="exact","Reponse.id"="exact","Question.id"="exact"})
 * 
 */
class Vote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"vote:read","vote:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true,options={"default" : null})
    
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Connaissance")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"vote:read","vote:write"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Connaissance::class, inversedBy="votes")
     * @Groups({"vote:read","vote:write"})
     */
    private $Connaissance;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="votes")
     * @Groups({"vote:read","vote:write"})
     */
    private $Question;

    /**
     * @ORM\ManyToOne(targetEntity=Reponse::class, inversedBy="votes")
     * @Groups({"vote:read","vote:write"})
     */
    private $Reponse;

    /**
     * @ORM\Column(type="boolean")
     *  * @Groups({"vote:read","vote:write"})
     */
    private $typeVote;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(?bool $type): self
    {
        $this->type = $type;

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

    public function getConnaissance(): ?Connaissance
    {
        return $this->Connaissance;
    }

    public function setConnaissance(?Connaissance $Connaissance): self
    {
        $this->Connaissance = $Connaissance;

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

    public function getReponse(): ?Reponse
    {
        return $this->Reponse;
    }

    public function setReponse(?Reponse $Reponse): self
    {
        $this->Reponse = $Reponse;

        return $this;
    }

    public function getTypeVote(): ?bool
    {
        return $this->typeVote;
    }

    public function setTypeVote(bool $typeVote): self
    {
        $this->typeVote = $typeVote;

        return $this;
    }
}
