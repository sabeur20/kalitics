<?php

namespace App\Entity;

use App\Repository\SitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SitesRepository::class)
 */
class Sites
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\OneToMany(targetEntity=Scores::class, mappedBy="sites")
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

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;

        return $this;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate)
    {
        $this->startDate = $startDate;

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
            $score->setSites($this);
        }

        return $this;
    }

    public function removeScore(Scores $score)
    {
        if ($this->scores->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getSites() === $this) {
                $score->setSites(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
