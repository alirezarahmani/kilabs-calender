<?php

namespace App\Domain\Entity;

use App\Domain\Model\BookTimesInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeSheetRepository")
 */
class TimeSheetEntity  implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $employer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $toDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function getEmployer(): ?EmployerEntity
    {
        return $this->employer;
    }

    public function setEmployer(?EmployerEntity $employer): self
    {
        $this->employer = $employer;
        return $this;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function setUser(?UserEntity $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setTime(BookTimesInterface $bookTimes): self
    {
        $this->date = $bookTimes->getDate();
        $this->toDate = $bookTimes->getTodate();
        return $this;
    }
}
