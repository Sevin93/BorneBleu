<?php

namespace App\Controller;

use App\Entity\Bornes;
use App\Form\BornesType;
use App\Repository\BornesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bornes')]
class BornesController extends AbstractController
{
    #[Route('/', name: 'app_bornes_index', methods: ['GET'])]
    public function index(BornesRepository $bornesRepository): Response
    {
        return $this->render('bornes/index.html.twig', [
            'bornes' => $bornesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bornes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BornesRepository $bornesRepository): Response
    {
        $borne = new Bornes();
        $form = $this->createForm(BornesType::class, $borne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bornesRepository->save($borne, true);

            return $this->redirectToRoute('app_bornes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bornes/new.html.twig', [
            'borne' => $borne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bornes_show', methods: ['GET'])]
    public function show(Bornes $borne): Response
    {
        return $this->render('bornes/show.html.twig', [
            'borne' => $borne,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bornes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bornes $borne, BornesRepository $bornesRepository): Response
    {
        $form = $this->createForm(BornesType::class, $borne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bornesRepository->save($borne, true);

            return $this->redirectToRoute('app_bornes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bornes/edit.html.twig', [
            'borne' => $borne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bornes_delete', methods: ['POST'])]
    public function delete(Request $request, Bornes $borne, BornesRepository $bornesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borne->getId(), $request->request->get('_token'))) {
            $bornesRepository->remove($borne, true);
        }

        return $this->redirectToRoute('app_bornes_index', [], Response::HTTP_SEE_OTHER);
    }
}
