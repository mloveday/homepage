<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CvInterestRepository")
 */
class CvInterest
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CurriculumVitae", inversedBy="skills")
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function setArchived(bool $archived): CvInterest
    {
        $this->archived = $archived;
        return $this;
    }

    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): CvInterest
    {
        $this->displayOrder = $displayOrder;
        return $this;
    }
}
