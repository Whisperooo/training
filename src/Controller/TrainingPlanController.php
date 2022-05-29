<?php

namespace App\Controller;

use App\Entity\TrainingPlan;
use App\Service\TrainingPlanGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrainingPlanController extends AbstractController
{
    /**
     * @Route("/tp/create", name="create", methods={"POST"})
     */
    public function createTrainingPlan(Request $request, TrainingPlanGenerator $generator): JsonResponse
    {
        $request->request->get('');

        $age = $request->request->get('age', 0);
        $sex = $request->request->get('sex', 0);
        $lvl = $request->request->get('lvl', 0);

        $all = $request->request->all();

        $parts = $all['parts'] ?? [0];
        $days  = $all['days']  ?? [0];

        $trainingPlan = $generator->generate($age, $sex, $lvl, $parts, $days);

        return $this->json($trainingPlan);
    }

    /**
     * @Route("/tp/{id}", name="show", methods={"GET"})
     */
    public function getTraining(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $trainingPlan = $entityManager->find(TrainingPlan::class, $id);

        return $this->json($trainingPlan);
    }
}
