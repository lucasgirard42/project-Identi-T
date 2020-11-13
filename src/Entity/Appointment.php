<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time_hour;

    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentary;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $staff;

   

   

    

    public function __construct()
    {
        // $this->staff = new ArrayCollection();
        $this->package = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTimeHour(): ?\DateTimeInterface
    {
        return $this->time_hour;
    }

    public function setTimeHour(?\DateTimeInterface $time_hour): self
    {
        $this->time_hour = $time_hour;

        return $this;
    }

    

   

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): self
    {
        $this->commentary = $commentary;

        return $this;
    }

    

   
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    
    
    public  function __toString()
    {
        return $this->getCommentary();
    }
    
}
