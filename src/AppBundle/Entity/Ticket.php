<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=10000)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended_at", type="datetime", nullable=true)
     */
    private $endedAt;

    /**
     * @var float
     *
     * @ORM\Column(name="timehours", type="float", nullable=true)
     */
    private $timehours;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="usertickets")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id", onDelete="cascade")
     */
    private $userId;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User",inversedBy="tickets", cascade={"persist","merge"})
     * @ORM\JoinTable(name="employee_ticket",
     *     joinColumns={@ORM\JoinColumn(name="employee_id",referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="ticket_id", referencedColumnName="id")})
     */
    private $employees;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Note", mappedBy="ticketId", cascade={"persist","remove"})
     */
    private $notes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->status = "Open";
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Ticket
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Ticket
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @return User
     * @throws \Exception
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set endedAt
     *
     * @param \DateTime $endedAt
     *
     * @return Ticket
     */
    public function setEndedAt($endedAt)
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * Get endedAt
     *
     * @return \DateTime
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * Set timehours
     *
     * @param float $timehours
     *
     * @return Ticket
     */
    public function setTimehours($timehours)
    {
        $this->timehours = $timehours;

        return $this;
    }

    /**
     * Get timehours
     *
     * @return float
     */
    public function getTimehours()
    {
        return $this->timehours;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Ticket
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * @param mixed $employees
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }


    /**
     * Add employee
     *
     * @param \AppBundle\Entity\User $employee
     *
     * @return ticket
     */
    public function addEmployee(\AppBundle\Entity\User $employee)
    {
        $this->employees[] = $employee;

        return $this;
    }

    /**
     * Remove employee
     *
     * @param \AppBundle\Entity\User $employee
     */
    public function removeEmployee(\AppBundle\Entity\User $employee)
    {
        $this->employees->removeElement($employee);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }



}

