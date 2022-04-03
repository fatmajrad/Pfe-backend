<?php

namespace App\Entity;

use App\Repository\SujetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"sujet:read"}},
 *     denormalizationContext={"groups"={"sujet:write"}},
 *     collectionOperations={"get","post"},
 *     itemOperations={"put","delete","get"}
 * )
 * @ORM\Entity(repositoryClass=SujetRepository::class)
 */
class Sujet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"sujet:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"sujet:read", "sujet:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"sujet:read", "sujet:write"})
     */
    private $descriptionSujet;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"sujet:read", "sujet:write"})
     */
    private $imageSujet;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class, mappedBy="tag")
     * @Groups({"sujet:read"})
     */
    private $questions;

   

    public function __construct()
    {
        $this->questions = new ArrayCollection();
       
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

   

}
