<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuestionRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"question:read"}},
 *     denormalizationContext={"groups"={"question:write"}}, 
 *     collectionOperations={"get","post",
 *     "count"={
 *           "path"="/questions/{statut}/count",
 *              "method"="GET",
 *              "controller" = App\Controller\CountAllQuestionsController::class,
 *     },"countIntervall"={
 *           "path"="/questions/{statut}/{minDate}/{maxDate}/countdate",
 *              "method"="GET",
 *              "controller" = App\Controller\CountIntervallQuestionsController::class,
 *     },"RecentQuestions"={
 *           "path"="/questions/recent",
 *              "method"="GET",
 *              "controller" = App\Controller\RecentQuestionsController::class,
 *     },"countIntervall"={
 *           "path"="/questions/{statut}/{minDate}/{maxDate}/countdate",
 *              "method"="GET",
 *              "controller" = App\Controller\CountIntervallQuestionsController::class,
 *      },"rated"={
 *           "path"="/questions/rated",
 *              "method"="GET",
 *              "controller" = App\Controller\BestQuestionsController::class,}
 *      },
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
 * 
 * @ApiFilter(SearchFilter::class,properties={"user.id":"exact","statut":"exact","intituleQuestion":"partial","tag.id"="exact"})
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
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="Question")
     *  @Groups({"question:read"})
     */
    private $votes;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"question:read","question:write"})
     */
    private $remarque;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"question:read","question:write"})
     */
    private $statut;

    /**
     * @Groups({"question:read","question:write"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @Groups({"question:read","question:write"})
     * @ORM\Column(type="date",nullable=true)
     */
    private $updatedAt;


    public function __construct()
    {   
        $this->createdAt = new \DateTime();
        $this->tag = new ArrayCollection();
        $this->statut="onHold";
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

   
    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

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

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
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
