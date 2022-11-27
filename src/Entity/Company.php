<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as Validator;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]

class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 11)]
    #[Assert\Length(min:9, max:9)]
    #[Validator\ValidSiren()]
    private string $codeSiren;

    #[ORM\Column(length: 255)]
    private ?string $cityRegistration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRegistration = null;

    #[ORM\Column(nullable: true)]
    private ?string $capital = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    private ?LegalStatus $legalStatus = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyHistory::class)]
    private Collection $companyHistories;

    #[ORM\ManyToMany(targetEntity: Adress::class, inversedBy: 'companies', cascade: ['persist'])]
    private Collection $adresses;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;


    public function __construct()
    {
        $this->companyHistories = new ArrayCollection();
        $this->adresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCodeSiren(): string
    {
        return $this->codeSiren;
    }

    public function setCodeSiren(string $codeSiren): self
    {
        $this->codeSiren = $codeSiren;

        return $this;
    }

    public function getCityRegistration(): ?string
    {
        return $this->cityRegistration;
    }

    public function setCityRegistration(string $cityRegistration): self
    {
        $this->cityRegistration = $cityRegistration;

        return $this;
    }

    public function getDateRegistration(): ?\DateTimeInterface
    {
        return $this->dateRegistration;
    }

    public function setDateRegistration(?\DateTimeInterface $dateRegistration): self
    {
        $this->dateRegistration = $dateRegistration;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(?string $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getLegalStatus(): ?LegalStatus
    {
        return $this->legalStatus;
    }

    public function setLegalStatus(?LegalStatus $legalStatus): self
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

    /**
     * @return Collection<int, CompanyHistory>
     */
    public function getCompanyHistories(): Collection
    {
        return $this->companyHistories;
    }

    public function addCompanyHistory(CompanyHistory $companyHistory): self
    {
        if (!$this->companyHistories->contains($companyHistory)) {
            $this->companyHistories->add($companyHistory);
            $companyHistory->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyHistory(CompanyHistory $companyHistory): self
    {
        if ($this->companyHistories->removeElement($companyHistory)) {
            // set the owning side to null (unless already changed)
            if ($companyHistory->getCompany() === $this) {
                $companyHistory->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Adress>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adress $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
        }

        return $this;
    }

    public function removeAdress(Adress $adress): self
    {
        $this->adresses->removeElement($adress);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
