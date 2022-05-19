<?php

namespace App\Entity;

use App\Repository\SujetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Api\FilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"sujet:read"}},
 *     denormalizationContext={"groups"={"sujet:write"}},
 *     collectionOperations={"get","post"},
 *     itemOperations={"put","delete","get"}
 * )
 * @ORM\Entity(repositoryClass=SujetRepository::class)
 * @ApiFilter(SearchFilter::class,properties={"nom":"partial"})
 */
class Sujet 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"sujet:read","question:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"sujet:read", "sujet:write","question:read","user:read","connaissance:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"sujet:read", "sujet:write"})
     */
    private $descriptionSujet;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"sujet:read"})
     */
    private $imageSujet;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class, mappedBy="tag")
     * @Groups({"sujet:read"})
     */
    private $questions;

    /**
     * @ORM\ManyToMany(targetEntity=Connaissance::class, mappedBy="sujet")
     */
    private $connaissances;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="intrestedTopics")
     */
    private $users;

   

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->connaissances = new ArrayCollection();
        $this->users = new ArrayCollection();
       
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescriptionSujet(): ?string
    {
        return $this->descriptionSujet;
    }

    public function setDescriptionSujet(?string $descriptionSujet): self
    {
        $this->descriptionSujet = $descriptionSujet;

        return $this;
    }

    public function getImageSujet()
    {
        return $this->imageSujet;
    }

    public function setImageSujet($imageSujet): self
    {
        $this->imageSujet = $imageSujet;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->addTag($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            $question->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Connaissance>
     */
    public function getConnaissances(): Collection
    {
        return $this->connaissances;
    }

    public function addConnaissance(Connaissance $connaissance): self
    {
        if (!$this->connaissances->contains($connaissance)) {
            $this->connaissances[] = $connaissance;
            $connaissance->addSujet($this);
        }

        return $this;
    }

    public function removeConnaissance(Connaissance $connaissance): self
    {
        if ($this->connaissances->removeElement($connaissance)) {
            $connaissance->removeSujet($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addIntrestedTopic($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeIntrestedTopic($this);
        }

        return $this;
    }

   

}
