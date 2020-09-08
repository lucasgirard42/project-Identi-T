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
     * @ORM\OneToMany(targetEntity=Staff::class, mappedBy="appointment")
     */
    private $staff;

    /**
     * @ORM\OneToMany(targetEntity=Package::class, mappedBy="appointment")
     */
    private $package;

    public function __construct()
    {
        $this->staff = new ArrayCollection();
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

    /**
     * @return Collection|Staff[]
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Staff $staff): self
    {
        if (!$this->staff->contains($staff)) {
            $this->staff[] = $staff;
            $staff->setAppointment($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staff->contains($staff)) {
            $this->staff->removeElement($staff);
            // set the owning side to null (unless already changed)
            if ($staff->getAppointment() === $this) {
                $staff->setAppointment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Package[]
     */
    public function getPackage(): Collection
    {
        return $this->package;
    }

    public function addPackage(Package $package): self
    {
        if (!$this->package->contains($package)) {
            $this->package[] = $package;
            $package->setAppointment($this);
        }

        return $this;
    }

    public function removePackage(Package $package): self
    {
        if ($this->package->contains($package)) {
            $this->package->removeElement($package);
            // set the owning side to null (unless already changed)
            if ($package->getAppointment() === $this) {
                $package->setAppointment(null);
            }
        }

        return $this;
    }
}
