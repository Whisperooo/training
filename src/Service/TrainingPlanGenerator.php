<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Entity\TrainingDay;
use App\Entity\TrainingPlan;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;

class TrainingPlanGenerator
{
    private static array $CNFG = [

        'age' => [
            18 => 1,
            25 => 2,
            40 => 3,
            50 => 2,
            99 => 1,
        ],

        'sex' => [
            0 => 1,
            1 => 2,
        ],

        'lvl' => [
            0 => 1,
            1 => 1.5,
            2 => 2,
        ],

    ];


    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generate(int $age, int $sex, int $lvl, array $parts, array $days): TrainingPlan
    {
        $trainingPlan = new TrainingPlan();
        $trainingPlan->setAge($age);
        $trainingPlan->setSex($sex);
        $trainingPlan->setLvl($lvl);
        $trainingPlan->setParts($parts);

        /** @var ExerciseRepository $repo */
        $repo = $this->entityManager->getRepository(Exercise::class);

        $matchedExercises = $repo->findMatchedExercises($lvl, $parts);

        if (empty($matchedExercises)) {
            die('No exercises found');
        }

        $max = $this->getExercisesCnt($age, $sex, $lvl);

        foreach ($days as $day) {

            $trainingDay = new TrainingDay();
            $trainingDay->setTrainingPlan($trainingPlan);
            $trainingDay->setDayNumber((int)$day);

            for ($ec = 0; $ec < $max; $ec++) {
                $exercise = $this->getExercise($matchedExercises);
                $trainingDay->addExercise($exercise);
            }

            $trainingPlan->addTrainingDay($trainingDay);
        }

        $this->entityManager->persist($trainingPlan);
        $this->entityManager->flush();

        return $trainingPlan;
    }

    private function getExercisesCnt(int $age, int $sex, int $lvl): int
    {
        $cnt = 5;
        $ageM = 1;

        foreach (self::$CNFG['age'] as $ac => $multi) {
            if ($age > $ac) {
                $ageM = $multi;
            }
        }

        $sex = self::$CNFG['sex'][$sex] ?? 1;
        $lvl = self::$CNFG['lvl'][$lvl] ?? 1;

        return (int) $cnt * $sex * $ageM * $lvl;
    }

    private function getExercise(array $matchedExercises): Exercise
    {
        return $matchedExercises[rand(0, count($matchedExercises))];
    }
}
