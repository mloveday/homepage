<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurriculumVitaeRepository")
 */
class CurriculumVitae
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $personalStatement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CvEmployer", mappedBy="curriculumVitae", orphanRemoval=true)
     */
    private $employers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CvSkill", mappedBy="curriculumVitae", orphanRemoval=true)
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CvEducator", mappedBy="curriculumVitae", orphanRemoval=true)
     */
    private $educators;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CvInterest", mappedBy="curriculumVitae", orphanRemoval=true)
     */
    private $interests;

    public function __construct()
    {
        $this->employers = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->educators = new ArrayCollection();
        $this->interests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPersonalStatement(): ?string
    {
        return $this->personalStatement;
    }

    public function setPersonalStatement(string $personalStatement): self
    {
        $this->personalStatement = $personalStatement;

        return $this;
    }

    /**
     * @return Collection|CvEmployer[]
     */
    public function getEmployers(): Collection
    {
        return $this->employers;
    }

    public function addEmployer(CvEmployer $employer): self
    {
        if (!$this->employers->contains($employer)) {
            $this->employers[] = $employer;
            $employer->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeEmployer(CvEmployer $employer): self
    {
        if ($this->employers->contains($employer)) {
            $this->employers->removeElement($employer);
            // set the owning side to null (unless already changed)
            if ($employer->getCurriculumVitae() === $this) {
                $employer->setCurriculumVitae(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CvSkill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(CvSkill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeSkill(CvSkill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            // set the owning side to null (unless already changed)
            if ($skill->getCurriculumVitae() === $this) {
                $skill->setCurriculumVitae(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CvEducator[]
     */
    public function getEducators(): Collection
    {
        return $this->educators;
    }

    public function addEducator(CvEducator $educator): self
    {
        if (!$this->educators->contains($educator)) {
            $this->educators[] = $educator;
            $educator->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeEducator(CvEducator $educator): self
    {
        if ($this->educators->contains($educator)) {
            $this->educators->removeElement($educator);
            // set the owning side to null (unless already changed)
            if ($educator->getCurriculumVitae() === $this) {
                $educator->setCurriculumVitae(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CvInterest[]
     */
    public function getInterests(): Collection
    {
        return $this->interests;
    }

    public function addInterest(CvInterest $interest): self
    {
        if (!$this->interests->contains($interest)) {
            $this->interests[] = $interest;
            $interest->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeInterest(CvInterest $interest): self
    {
        if ($this->interests->contains($interest)) {
            $this->interests->removeElement($interest);
            // set the owning side to null (unless already changed)
            if ($interest->getCurriculumVitae() === $this) {
                $interest->setCurriculumVitae(null);
            }
        }

        return $this;
    }
}
