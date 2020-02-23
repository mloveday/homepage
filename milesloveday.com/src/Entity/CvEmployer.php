<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CvEmployerRepository")
 */
class CvEmployer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dates;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jobTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CurriculumVitae", inversedBy="employers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $curriculumVitae;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $archived = false;

    /**
     * @ORM\Column(type="integer", options={"default":1})
     */
    private $displayOrder = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDates(): ?string
    {
        return $this->dates;
    }

    public function setDates(string $dates): self
    {
        $this->dates = $dates;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCurriculumVitae(): ?CurriculumVitae
    {
        return $this->curriculumVitae;
    }

    public function setCurriculumVitae(?CurriculumVitae $curriculumVitae): self
    {
        $this->curriculumVitae = $curriculumVitae;

        return $this;
    }

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): CvEmployer
    {
        $this->archived = $archived;
        return $this;
    }

    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): CvEmployer
    {
        $this->displayOrder = $displayOrder;
        return $this;
    }
}
