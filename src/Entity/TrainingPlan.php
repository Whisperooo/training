<?php


namespace App\Entity;

use App\Repository\TrainingPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainingPlanRepository::class)
 */
class TrainingPlan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public int $age;

    /**
     * @ORM\Column(type="integer")
     */
    public int $sex;

    /**
     * @ORM\Column(type="integer")
     */
    public int $lvl;

    /**
     * @ORM\Column(type="array")
     */
    public array $parts;

    /**
     * @ORM\OneToMany(targetEntity="TrainingDay", mappedBy="trainingPlan", cascade={"persist"})
     */
    public Collection $trainingDays;

    public function __construct()
    {
        $this->age = 0;
        $this->sex = 0;
        $this->lvl = 0;
        $this->parts = [0];
        $this->trainingDays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getSex(): int
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     */
    public function setSex(int $sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return int
     */
    public function getLvl(): int
    {
        return $this->lvl;
    }

    /**
     * @param int $lvl
     */
    public function setLvl(int $lvl): void
    {
        $this->lvl = $lvl;
    }

    /**
     * @return int[]
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    /**
     * @param int[] $parts
     */
    public function setParts(array $parts): void
    {
        $this->parts = $parts;
    }

    /**
     * @return Collection
     */
    public function getTrainingDays(): Collection
    {
        return $this->trainingDays;
    }

    /**
     * @param Collection $trainingDays
     */
    public function setTrainingDays(Collection $trainingDays): void
    {
        $this->trainingDays = $trainingDays;
    }

    public function addTrainingDay(TrainingDay $trainingDay): void
    {
        $this->trainingDays->add($trainingDay);
    }
}
