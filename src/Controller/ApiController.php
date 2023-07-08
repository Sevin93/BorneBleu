<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlanningRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Planning;
use App\Repository\BornesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApiController extends AbstractController
{

    #[Route('/api/planning', name: 'api_get_planning', methods: ['GET'])]
    public function apiGetPlanning(PlanningRepository $planningRepository, Request $request): JsonResponse
    {
        $nbHeure = $request->query->get('nbHeure');
        $selectedDate = $request->query->get('selectedDate');

        if (!$nbHeure || !$selectedDate) {
            return new JsonResponse(['error' => 'Missing parameters'], 400);
        }

        $selectedDatetime = \DateTime::createFromFormat('d/m/Y', $selectedDate);
        $workStart = clone $selectedDatetime;
        $workStart->setTime(8,0,0);
        $workEnd = clone $selectedDatetime;
        $workEnd = $selectedDatetime->setTime(18,0,0);

        $plannings = $planningRepository->findBydate($selectedDatetime);
        $slots = self::generateSlots($nbHeure, $workStart, $workEnd, $plannings);

        return new JsonResponse($slots);
    }

    #[Route('/api/planning/new', name: 'api_new_planning', methods: ['POST'])]
    public function apiNewPlanning(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, BornesRepository $bornesRepository, PlanningRepository $planningRepository): JsonResponse
    {
        // Obtenir les données de la requête
        $data = json_decode($request->getContent(), true);

        // Créer un nouvel objet Planning
        $planning = new Planning();

        // Définir le nombre d'heures
        $planning->setNbHeure($data['nbHeure']);

        // Convertir la date sélectionnée en objet DateTime
        $selectedDateFr = $data['selectedDate'];
        $selectedDate = \DateTime::createFromFormat('d/m/Y', $selectedDateFr);

        // Diviser le créneau horaire en heure de début et heure de fin
        list($startTime, $endTime) = explode('-', $data['creneau']);

        // Convertir l'heure de début et de fin en objets DateTime
        $startDateTime = clone $selectedDate;
        $startDateTime->setTime(...explode(':', $startTime));

        $endDateTime = clone $selectedDate;
        $endDateTime->setTime(...explode(':', $endTime));

        // Définir l'heure de début et de fin
        $planning->setHeureDebut($startDateTime);
        $planning->setHeureFin($endDateTime);
        $planning->setDate($selectedDate);

        if ($this->getUser()) {
            $currentUser = $userRepository->findOneBy(["email" => $this->getUser()->getEmail()]);
            $planning->setUser($currentUser);
        }

        // Obtenir une borne_id non utilisée
        $borneId = $this->getAvailableBorneId($startDateTime, $endDateTime, $planningRepository, $bornesRepository);

        // Si aucune borne_id n'est disponible, renvoyer une erreur
        if ($borneId === null) {
            return new JsonResponse(['message' => 'No available borne_id'], Response::HTTP_BAD_REQUEST);
        }

        // Définir la borne_id
        $planning->setBorneId($borneId);

        // Sauvegarder le nouvel objet Planning dans la base de données
        $entityManager->persist($planning);
        $entityManager->flush();

        // Renvoyer une réponse avec les détails du nouveau planning
        return new JsonResponse(["message"=>"OK"], Response::HTTP_CREATED);
    }

    private function generateSlots($hours, $workStart, $workEnd, $plannings = [])
    {
        $timeSlots = [];

        $interval = new \DateInterval('PT30M');
        $duration = new \DateInterval('PT' . $hours . 'H');

        for ($start = clone $workStart; $start < $workEnd; $start->add($interval)) {
            $end = clone $start;
            $end->add($duration);

            if ($end > $workEnd) {
                continue;
            }

            if (!$this->isSlotFullyBooked($start, $end, $plannings)) {
                $timeSlots[] = $start->format('H:i') . '-' . $end->format('H:i');
            }
        }

        return $timeSlots;
    }

    private function isSlotFullyBooked($start, $end, $plannings)
    {
        $bookedCount = 0;
        foreach ($plannings as $planning) {
            $planningStart = $planning->getHeureDebut();
            $planningEnd = $planning->getHeureFin();

            if (($start >= $planningStart && $start <= $planningEnd) || ($end >= $planningStart && $end <= $planningEnd)) {
                $bookedCount += 1;
            }
        }

        return $bookedCount >= 5;
    }

    private function getAvailableBorneId($startDateTime, $endDateTime, PlanningRepository $planningRepository, BornesRepository $bornesRepository)
    {
        $excludeBorneIds = [];

        //startDate in intervalle
        $plannings = $planningRepository->findByDateTime($startDateTime);
        foreach ($plannings as $planning) {
            if ($planning->getBorneId()) {
                $excludeBorneIds[] = $planning->getBorneId()->getId();
            }
        }

        //endDate in intervalle
        $plannings = $planningRepository->findByDateTime($endDateTime);
        foreach ($plannings as $planning) {
            if ($planning->getBorneId()) {
                $excludeBorneIds[] = $planning->getBorneId()->getId();
            }
        }

        $borne = $bornesRepository->findOneByIdsNotIn($excludeBorneIds);

        return ($borne) ? $borne : null;
    }
}
