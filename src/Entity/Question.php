<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\User;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"question:read"}},
 *     denormalizationContext={"groups"={"question:write"}}, 
 *     collectionOperations={"get","post"},
 *     itemOperations={
 *        "delete","PUT",
 *        "get",
 *        "decline_question"={
 *          "method"="Put",
 *          "path"="/questions/{id}/decline",
 *          "controller"=App\Controller\DeclineQuestionController::class,
 *          "openapi_context"={
 *              "summary"="permet de valider une question",
 *              "requestBody" = { 
 *                       "content" ={
 *                            "application/json"={
 *                                "schema"={},
 *                                "example"={}}}}}
 *          
 *        },
 *       "validate_question"={
 *          "method"="Put",
 *          "path"="/questions/{id}/validate",
 *          "controller"=App\Controller\ValidateQuestionController::class,
 *          "openapi_context"={
 *              "summary"="permet de refuser une question",
 *              "requestBody" = {
 *                       "content" ={
 *                            "application/json"={
 *                                "schema"={},
 *                                "example"={}}}}}
 *
 *     },
 *      "publish_question"={
 *          "method"="Put",
 *          "path"="/questions/{id}/publish",
 *          "controller"=App\Controller\PublishQuestionController::class,
 *          "openapi_context"={
 *              "summary"="permet de refuser une question",
 *              "requestBody" = {
 *                       "content" ={
 *                            "application/json"={
 *                                "schema"={},
 *                                "example"={}}}}}
 *
 *     }
 * })
 * @ApiFilter(BooleanFilter::class,properties={"statutValidation", "brouillon"})
 * @ApiFilter(SearchFilter::class,properties={"user.id":"exact"})
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id  
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"question:read","reponse:read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"question:read", "question:write"})
     * 
     */
    private $intituleQuestion;

    /**
     * @ORM\Column(type="text")
     * @Groups({"question:read", "question:write"})
     */
    private $descriptionQuestion;

    /**
     * @ORM\Column(type="blob", nullable=true)
   
     */
    private $imageCode;

    /**
     * @ORM\Column(type="text", nullable=true)
   
     */
    private $fragmentCode;

    /**
     * @ORM\ManyToMany(targetEntity=Sujet::class, inversedBy="questions")
     * @Groups({"question:read","question:write"})
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="questions")
     * @Groups({"question:read","question:write"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="Question")
     * @Groups({"question:read"})
     */
    private $reponses;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"question:read","question:write"})
     */
    private $brouillon;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"question:read","question:write"})
     */
    private $statutValidation;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="Question")
     *  @Groups({"question:read"})
     */
    private $votes;

    

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->user = new User;
        $this->reponses = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleQuestion(): ?string
    {
        return $this->intituleQuestion;
    }

    public function setIntituleQuestion(string $intituleQuestion): self
    {
        $this->intituleQuestion = $intituleQuestion;

        return $this;
    }

    public function getDescriptionQuestion(): ?string
    {
        return $this->descriptionQuestion;
    }

    public function setDescriptionQuestion(string $descriptionQuestion): self
    {
        $this->descriptionQuestion = $descriptionQuestion;

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

    public function getFragmentCode(): ?string
    {
        return $this->fragmentCode;
    }

    public function setFragmentCode(?string $fragmentCode): self
    {
        $this->fragmentCode = $fragmentCode;

        return $this;
    }

    /**
     * @return Collection<int, sujet>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(sujet $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(sujet $tag): self
    {
        $this->tag->removeElement($tag);

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
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }

    public function getBrouillon(): ?bool
    {
        return $this->brouillon;
    }

    public function setBrouillon(?bool $brouillon): self
    {
        $this->brouillon = $brouillon;

        return $this;
    }

    public function getStatutValidation(): ?bool
    {
        return $this->statutValidation;
    }

    public function setStatutValidation(?bool $statutValidation): self
    {
        $this->statutValidation = $statutValidation;

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
            $vote->setQuestion($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getQuestion() === $this) {
                $vote->setQuestion(null);
            }
        }

        return $this;
    }
    

}
