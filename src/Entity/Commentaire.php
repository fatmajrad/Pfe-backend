<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"commentaire:read"}},
 *     denormalizationContext={"groups"={"commentaire:write"}},
 *     collectionOperations={
 *       "get","post",
 *       "count"={
 *           "path"="/count",
 *              "method"="GET",
 *              "controller" = App\Controller\CountCommentsController::class,
 *       }
 *     })
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
     * @Groups({"commentaire:write","commentaire:read","reponse:read","question:read"})
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     * @Groups({"commentaire:write","commentaire:read","reponse:read","question:read"})
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
}
