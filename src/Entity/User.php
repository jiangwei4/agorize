<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Faker\Test\Provider\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];
    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="user")
     */
    private $articles;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Conges", mappedBy="user", cascade={"remove"})
     */
    private $conges;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projet", mappedBy="user")
     */
    private $projets;

    private $firstname;

    private $lastname;

    /**
     * @Assert\DateTime()
     */
    private $birthday;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->conges = new ArrayCollection();
        $this->projets = new ArrayCollection();
        $this->roles = array ('ROLE_USER');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }



    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }
    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }
    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }
    /**
     * @return mixed
     */
    public function getConges()
    {
        return $this->conges;
    }
    public function addConge(Conges $conge): self
    {
        if (!$this->articles->contains($conge)) {
            $this->articles[] = $conge;
            $conge->setUser($this);
        }

        return $this;
    }
    public function removeConge(Conges $conge): self
    {
        if ($this->conges->contains($conge)) {
            $this->conges->removeElement($conge);
            // set the owning side to null (unless already changed)
            if ($conge->getUser() === $this) {
                $conge->setUser(null);
            }
        }

        return $this;
    }


    public function getProjets()
    {
        return $this->conges;
    }
    public function addProjets(Projet $projet): self
    {
        if (!$this->articles->contains($projet)) {
            $this->articles[] = $projet;
            $projet->setUser($this);
        }

        return $this;
    }
    public function removeProjets(Projet $projet): self
    {
        if ($this->conges->contains($projet)) {
            $this->conges->removeElement($projet);
            // set the owning side to null (unless already changed)
            if ($projet->getUser() === $this) {
                $projet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }


    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

}
