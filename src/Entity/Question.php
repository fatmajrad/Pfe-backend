<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\User;
/**
 * @ApiResource(
 *  normalizationContext={"groups"={"question:read"}},
 *     denormalizationContext={"groups"={"question:write"}},
 *     collectionOperations={"get","post"},
 *     itemOperations={"put","delete","get"})
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"question:read", "question:write"})
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
     * @Groups({"question:read", "question:write"})
     */
    private $imageCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"question:read", "question:write"})
     */
    private $fragmentCode;

    /**
     * @ORM\ManyToMany(targetEntity=Sujet::class, inversedBy="questions")
     * @Groups({"question:read", "question:write"})
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="questions")
     * @Groups({"question:read", "question:write"})
     */
    private $user;


    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->user = new User;
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

    

}
