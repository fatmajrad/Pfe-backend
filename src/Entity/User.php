<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;

use ApiPlatform\Core\Annotation\ApiResource;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * 
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 *     collectionOperations={
 *        "get",
 *        "post",
 *        "me"= {
 *              "pagination_enabled"= false,
 *              "path"="/me",
 *              "method"="GET",
 *              "controller" = App\Controller\MeController::class
 *              }
 *      },
 *    
 *     itemOperations={
 *        "delete","PUT",
 *        "get"= {
 *           "controller" = App\Controller\NotFoundAction::class,
 *           "openapi_context" = {"summary" = "hidden"}
 *         },
 *         "validate_user"={
 *          "method"="Put",
 *          "path"="/users/{id}/validate",
 *          "controller"=App\Controller\ValidateUserController::class,
 *          "openapi_context"={
 *              "summary"="permet de valider un user",
 *              "requestBody" = { 
 *                       "content" ={
 *                            "application/json"={
 *                                "schema"={},
 *                                "example"={}}}}}
 *          
 *        },
 *       "decline_user"={
 *          "method"="Put",
 *          "path"="/users/{id}/decline",
 *          "controller"=App\Controller\DeclineUserController::class,
 *          "openapi_context"={
 *              "summary"="permet de refuser un user",
 *              "requestBody" = {
 *                       "content" ={
 *                            "application/json"={
 *                                "schema"={},
 *                                "example"={}}}}}
 *
 *     }
 * })
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"}) 
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     */
    private $nomUser;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $userFonction;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"user:read"})
     */
    private $validatedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"user:read"})
     */
    private $demandedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:read"})
     */
    private $statutValidation = null;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="user")
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity=Reponse::class, inversedBy="user")
     */
    private $reponse;

    /**
     * @ORM\ManyToMany(targetEntity=Reponse::class, mappedBy="Vote")
     */
    private $votes;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="user")
     */
    private $reponses;

    /**
     * @ORM\ManyToMany(targetEntity=Reponse::class, mappedBy="commentaire")
     */
    private $commentaires;

 


    public function __construct()
    {
        $this->demandedAt = new \DateTimeImmutable('now');
        $this->questions = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->reponses = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }  


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        //$this->plainPassword = null;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }


    public function getUserFonction(): ?string
    {
        return $this->userFonction;
    }

    public function setUserFonction(?string $userFonction): self
    {
        $this->userFonction = $userFonction;

        return $this;
    }

    public function getValidatedAt(): ?\DateTimeImmutable
    {
        return $this->validatedAt;
    }

    public function setValidatedAt(?\DateTimeImmutable $validatedAt): self
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    public function getDemandedAt(): ?\DateTimeImmutable
    {
        return $this->demandedAt;
    }

    public function setDemandedAt(?\DateTimeImmutable $demandedAt): self
    {
        $this->demandedAt = $demandedAt;

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


    public static function createFromPayload($id, array $payload)
    {
       
        return (new User())->setId($id);
    }

    private function setId(?int $id):self
    {
        $this->id=$id;
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
            $question->setUser($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getUser() === $this) {
                $question->setUser(null);
            }
        }

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Reponse $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->addVote($this);
        }

        return $this;
    }

    public function removeVote(Reponse $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            $vote->removeVote($this);
        }

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
            $reponse->setUser($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getUser() === $this) {
                $reponse->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Reponse $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->addCommentaire($this);
        }

        return $this;
    }

    public function removeCommentaire(Reponse $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            $commentaire->removeCommentaire($this);
        }

        return $this;
    }

 


}