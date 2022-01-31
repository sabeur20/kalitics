<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"registration_number"})}
 *     )
 * @UniqueEntity(
 *      fields={"registrationNumber"},
 *      message="Cette Matricule a été utilisée par un autre utilisateur, Veuillez réessayer par une autre"
 * )
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $registrationNumber;

    /**
     * @ORM\OneToMany(targetEntity=Scores::class, mappedBy="users")
     */
    private $scores;

    public function __construct()
    {
        $this->scores = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public
    function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * @return Collection|Scores[]
     */
    public function getScores()
    {
        return $this->scores;
    }

    public function addScore(Scores $score)
    {
        if (!$this->scores->contains($score)) {
            $this->scores[] = $score;
            $score->setUsers($this);
        }

        return $this;
    }

    public function removeScore(Scores $score)
    {
        if ($this->scores->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getUsers() === $this) {
                $score->setUsers(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->lastname . " " . $this->firstname;
    }
}
