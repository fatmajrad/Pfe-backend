<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"commentaire:read"}},
 *     denormalizationContext={"groups"={"commentaire:write"}},
 *     collectionOperations={
 *       "get","post",
 *       "count"={
 *           "path"="{idUser}/{idConnaissance}/{idReponse}/count",
 *              "method"="GET",
 *              "controller" = App\Controller\CountCommentsController::class,
 *       }
 *     })
 * @ApiFilter(SearchFilter::class,properties={"user.id":"exact"})
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"commentaire:read","reponse:read","question:read","connaissance:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"commentaire:write","commentaire:read","reponse:read","question:read","connaissance:read"})
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     * @Groups({"commentaire:write","commentaire:read","reponse:read","question:read","connaissance:read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Reponse::class, inversedBy="commentaires")
     * @Groups({"commentaire:write","commentaire:read"})
     */
    private $reponse;

    /**
     * @ORM\ManyToOne(targetEntity=Connaissance::class, inversedBy="commentaires")
     * @Groups({"commentaire:write","commentaire:read"})
     */
    private $connaissance;

    /**
     * @ORM\Column(type="date")
     * @Groups({"commentaire:write","commentaire:read","question:read","connaissance:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date",nullable=true)
     * @Groups({"commentaire:write","commentaire:read","question:read","connaissance:read"})
     */
    private $updatedAt;

    public function __construct()
    {   $this->createdAt = new \DateTime();
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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getReponse(): ?reponse
    {
        return $this->reponse;
    }

    public function setReponse(?reponse $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getConnaissance(): ?connaissance
    {
        return $this->connaissance;
    }

    public function setConnaissance(?connaissance $connaissance): self
    {
        $this->connaissance = $connaissance;

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
