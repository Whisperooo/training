<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class TrainingDay
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
    public int $dayNumber;

    /**
     * @ORM\ManyToOne(targetEntity="TrainingPlan", inversedBy="trainingDays")
     * @ORM\JoinColumn(name="training_plan_id", referencedColumnName="id")
     */
    private TrainingPlan $trainingPlan;

    /**
     * @ORM\ManyToMany(targetEntity="Exercise")
     * @ORM\JoinTable(name="training_days_exercises",
     *      joinColumns={@ORM\JoinColumn(name="training_day_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="exercise_id", referencedColumnName="id")}
     * )
     */
    public Collection $exercises;

    public function __construct()
    {
        $this->dayNumber = 0;
        $this->exercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDayNumber(): int
    {
        return $this->dayNumber;
    }

    /**
     * @param int $dayNumber
     */
    public function setDayNumber(int $dayNumber): void
    {
        $this->dayNumber = $dayNumber;
    }


    /**
     * @param TrainingPlan $trainingPlan
     */
    public function setTrainingPlan(TrainingPlan $trainingPlan): void
    {
        $this->trainingPlan = $trainingPlan;
    }

    /**
     * @return Collection
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    /**
     * @param Collection $exercises
     */
    public function setExercises(Collection $exercises): void
    {
        $this->exercises = $exercises;
    }

    /**
     * @param Exercise $exercise
     */
    public function addExercise(Exercise $exercise): void
    {
        $this->exercises->add($exercise);
    }
}
