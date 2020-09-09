<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $costumerPicture;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fidelityCard;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    // /**
    //  * @ORM\OneToOne(targetEntity=Appointment::class, cascade={"persist", "remove"})
    //  */
    // private $appointment;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="customer", orphanRemoval=true)
     */
    private $appointments;

    // /**
    //  * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="customer")
    //  */
    // private $customer;

    // /**
    //  * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="customer", orphanRemoval=true)
    //  */
    // private $customer;

    public function __construct()
    {
        $this->customer = new ArrayCollection();
        $this->apple = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(?bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCostumerPicture(): ?string
    {
        return $this->costumerPicture;
    }

    public function setCostumerPicture(?string $costumerPicture): self
    {
        $this->costumerPicture = $costumerPicture;

        return $this;
    }

    public function getFidelityCard(): ?bool
    {
        return $this->fidelityCard;
    }

    public function setFidelityCard(?bool $fidelityCard): self
    {
        $this->fidelityCard = $fidelityCard;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    // public function getAppointment(): ?Appointment
    // {
    //     return $this->appointment;
    // }

    // public function setAppointment(?Appointment $appointment): self
    // {
    //     $this->appointment = $appointment;

    //     return $this;
    // }

    // /**
    //  * @return Collection|Appointment[]
    //  */
    // public function getCustomer(): Collection
    // {
    //     return $this->customer;
    // }

    // public function addCustomer(Appointment $customer): self
    // {
    //     if (!$this->customer->contains($customer)) {
    //         $this->customer[] = $customer;
    //         $customer->setCustomer($this);
    //     }

    //     return $this;
    // }

    // public function removeCustomer(Appointment $customer): self
    // {
    //     if ($this->customer->contains($customer)) {
    //         $this->customer->removeElement($customer);
    //         // set the owning side to null (unless already changed)
    //         if ($customer->getCustomer() === $this) {
    //             $customer->setCustomer(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection|Appointment[]
    //  */
    // public function getApple(): Collection
    // {
    //     return $this->apple;
    // }

    // public function addApple(Appointment $apple): self
    // {
    //     if (!$this->apple->contains($apple)) {
    //         $this->apple[] = $apple;
    //         $apple->setCustomer2($this);
    //     }

    //     return $this;
    // }

    // public function removeApple(Appointment $apple): self
    // {
    //     if ($this->apple->contains($apple)) {
    //         $this->apple->removeElement($apple);
    //         // set the owning side to null (unless already changed)
    //         if ($apple->getCustomer2() === $this) {
    //             $apple->setCustomer2(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setCustomer($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->contains($appointment)) {
            $this->appointments->removeElement($appointment);
            // set the owning side to null (unless already changed)
            if ($appointment->getCustomer() === $this) {
                $appointment->setCustomer(null);
            }
        }

        return $this;
    }

    public  function __toString()
    {
        return $this->getLastName();
    }
}
