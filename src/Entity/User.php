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
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

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
 *              },
 *        "count"={
 *           "path"="/users/{statut}/count",
 *              "method"="GET",
 *              "controller" = App\Controller\CountAllUsersController::class,
 *       },
 *       "countIntervall"={
 *           "path"="/users/{statut}/{minDate}/{maxDate}/countdate",
 *              "method"="GET",
 *              "controller" = App\Controller\CountIntervallUsersController::class,
 *     },"getAllUsers"={
 *           "path"="users/allUsers",
 *              "method"="GET",
 *              "controller" = App\Controller\GetAllUsersController::class,
 *      }
 *     },
 *     itemOperations={
 *        "delete","PUT","patch",
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
 *                                 "schema"={},
 *                                "example"={}}}}}
 *          
 *        },
 * })
 * @ApiFilter(SearchFilter::class,properties={"id":"exact","statut":"exact","nomUser":"partial","email"="partial"})
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read","question:read","reponse:read","commentaire:read","connaissance:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write","connaissance:read"})
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
     * @Groups({"user:read", "user:write","connaissance:read","question:read","reponse:read","commentaire:read"})
     */
    private $nomUser;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $userFonction;


    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="user", cascade={"persist","remove"})
     * @Groups({"user:read"})
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity=Connaissance::class, mappedBy="user")
     * @Groups({"user:read"})
     */
    private $connaissances;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="user")
     * @Groups({"user:read"})
     */
    private $reponses;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="user")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="user", orphanRemoval=true)
     */
    private $Connaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read","user:write"})
     */
    private $remarque;

/**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read"})
     */
    private $statut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date",nullable=true)
     * @Groups({"user:read"})
     */
    private $validatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user:read","user:write"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Sujet::class, inversedBy="users")
     * @Groups({"user:read","user:write"})
     */
    private $intrestedTopics;
   

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->statut="onHold";
        $this->questions = new ArrayCollection();
        $this->connaissances = new ArrayCollection();
        $this->reponses = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->Connaissance = new ArrayCollection();
        $this->intrestedTopics = new ArrayCollection();
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
            $connaissance->setUser($this);
        }

        return $this;
    }

    public function removeConnaissance(Connaissance $connaissance): self
    {
        if ($this->connaissances->removeElement($connaissance)) {
            // set the owning side to null (unless already changed)
            if ($connaissance->getUser() === $this) {
                $connaissance->setUser(null);
            }
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
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getConnaissance(): Collection
    {
        return $this->Connaissance;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(string $remarque): self
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

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validatedAt;
    }

    public function setValidatedAt(\DateTimeInterface $validatedAt): self
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, sujet>
     */
    public function getIntrestedTopics(): Collection
    {
        return $this->intrestedTopics;
    }

    public function addIntrestedTopic(sujet $intrestedTopic): self
    {
        if (!$this->intrestedTopics->contains($intrestedTopic)) {
            $this->intrestedTopics[] = $intrestedTopic;
        }

        return $this;
    }

    public function removeIntrestedTopic(sujet $intrestedTopic): self
    {
        $this->intrestedTopics->removeElement($intrestedTopic);

        return $this;
    }  
  

}
