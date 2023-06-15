<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\BornesRepository;
use App\Repository\PlanningRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;





#[Route('/planning')]
class PlanningController extends AbstractController

{
    private $mailer ;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;

    }

    #[Route('/', name: 'app_planning_index', methods: ['GET'])]
    public function index(PlanningRepository $planningRepository): Response
    {
        if($this->getUser() === null){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('planning/index.html.twig', [
            'plannings' => $planningRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_planning_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlanningRepository $planningRepository): Response
    {
        $form = $this->createForm(PlanningType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $planningRepository->save($planning, true);
            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/new.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/nouveau/{id}', name: 'app_planning_nouveau', methods: ['GET', 'POST'])]
    public function nouveau(Request $request, PlanningRepository $planningRepository): Response
    {
        $planning = new Planning();


        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planningRepository->save($planning, true);

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/nouveau.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planning_show', methods: ['GET'])]
    public function show(Planning $planning): Response
    {
        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_planning_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planning $planning, PlanningRepository $planningRepository): Response
    {
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planningRepository->save($planning, true);

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planning_delete', methods: ['POST'])]
    public function delete(Request $request, Planning $planning, PlanningRepository $planningRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planning->getId(), $request->request->get('_token'))) {
            $planningRepository->remove($planning, true);
        }

        return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/reservation/{borneId}', name: 'app_planning_reservation', methods: ['GET', 'POST'])]
    public function reservation($id, $borneId, BornesRepository $bornesRepository, Planning $planning, PlanningRepository $planningRepository): Response
    {
            $planning->setUser($this->getUser());
            $planning->setBorneId($bornesRepository->find($borneId));
            $planning->setPris(true);
            $planningRepository->save($planning, true);
            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/reservation/user', name: 'app_planning_user', methods: ['GET'])]
    public function myReservation(PlanningRepository $planningRepository): Response
    {
        return $this->render('planning/myReservation.html.twig', [
            'plannings' => $planningRepository->findOrderDate($this->getUser()),
        ]);
    }

    #[Route('/reservation/email/{nbHeure}/{day}/{month}/{year}/{creneau}', name: 'app_planning_email', methods: ['GET'])]
    public function sendmail($nbHeure, $day,$month, $year, $creneau, PlanningRepository $planningRepository){

      $email=(new TemplatedEmail())
          ->from("sevinmigfer@gmail.com")
          ->to($this->getUser()->getEmail())
          ->subject("Information de la réservation")
          ->htmlTemplate("planning/email.html.twig")
          ->context([
              'nbHeure'=>$nbHeure,
              'day' => $day,
              'month' =>$month,
              'year' =>$year,
              'creneau' => $creneau
          ]);
      $this->mailer->send($email);
      return $this->redirectToRoute("app_planning_user");
    }
}
