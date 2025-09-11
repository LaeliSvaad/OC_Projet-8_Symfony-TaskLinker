<?php

namespace App\Entity;

use App\Enum\EmployeeContract;
use App\Repository\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column(length: 150)]
    private ?string $lastname = null;

    #[ORM\Column(length: 150)]
    private ?string $email = null;

    #[ORM\Column(enumType: EmployeeContract::class)]
    private ?EmployeeContract $contract = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $arrival_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getContract(): ?EmployeeContract
    {
        return $this->contract;
    }

    public function setContract(EmployeeContract $contract): static
    {
        $this->contract = $contract;

        return $this;
    }

    public function getArrivalDate(): ?\DateTime
    {
        return $this->arrival_date;
    }

    public function setArrivalDate(\DateTime $arrival_date): static
    {
        $this->arrival_date = $arrival_date;

        return $this;
    }
}
