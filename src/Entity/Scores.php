<?php

namespace App\Entity;

use App\Repository\ScoresRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ScoresRepository::class)
 *
 */
class Scores
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="scores")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Sites::class, inversedBy="scores")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $sites;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $scoreDate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $lengthTime;

    public function getId()
    {
        return $this->id;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function setUsers(users $users)
    {
        $this->users = $users;

        return $this;
    }

    public function getSites()
    {
        return $this->sites;
    }

    public function setSites(Sites $sites)
    {
        $this->sites = $sites;

        return $this;
    }

    public function getScoreDate()
    {
        return $this->scoreDate;
    }

    public function setScoreDate(\DateTimeInterface $scoreDate)
    {
        $this->scoreDate = $scoreDate;

        return $this;
    }

    public function getLengthTime()
    {
        return $this->lengthTime;
    }

    public function setLengthTime(int $lengthTime)
    {
        $this->lengthTime = $lengthTime;

        return $this;
    }
}
