<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Form\AffectationType;
use App\Repository\AffectationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affectationcrud')]
class AffectationcrudController extends AbstractController
{
    #[Route('/', name: 'app_affectationcrud_index', methods: ['GET'])]
    public function index(AffectationRepository $affectationRepository): Response
    {
        return $this->render('affectationcrud/index.html.twig', [
            'affectations' => $affectationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_affectationcrud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AffectationRepository $affectationRepository): Response
    {
        $affectation = new Affectation();
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affectationRepository->save($affectation, true);

            return $this->redirectToRoute('app_affectationcrud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affectationcrud/new.html.twig', [
            'affectation' => $affectation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affectationcrud_show', methods: ['GET'])]
    public function show(Affectation $affectation): Response
    {
        return $this->render('affectationcrud/show.html.twig', [
            'affectation' => $affectation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affectationcrud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affectation $affectation, AffectationRepository $affectationRepository): Response
    {
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $affectationRepository->save($affectation, true);

            return $this->redirectToRoute('app_affectationcrud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affectationcrud/edit.html.twig', [
            'affectation' => $affectation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affectationcrud_delete', methods: ['POST'])]
    public function delete(Request $request, Affectation $affectation, AffectationRepository $affectationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affectation->getId(), $request->request->get('_token'))) {
            $affectationRepository->remove($affectation, true);
        }

        return $this->redirectToRoute('app_affectationcrud_index', [], Response::HTTP_SEE_OTHER);
    }
}
