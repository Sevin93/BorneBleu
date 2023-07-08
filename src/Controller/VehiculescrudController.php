<?php

namespace App\Controller;

use App\Entity\Vehicules;
use App\Form\VehiculesType;
use App\Repository\VehiculesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehiculescrud')]
class VehiculescrudController extends AbstractController
{
    #[Route('/', name: 'app_vehiculescrud_index', methods: ['GET'])]
    public function index(VehiculesRepository $vehiculesRepository): Response
    {
        return $this->render('vehiculescrud/index.html.twig', [
            'vehicules' => $vehiculesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vehiculescrud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehiculesRepository $vehiculesRepository): Response
    {
        $vehicule = new Vehicules();
        $form = $this->createForm(VehiculesType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehiculesRepository->save($vehicule, true);

            return $this->redirectToRoute('app_vehiculescrud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehiculescrud/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehiculescrud_show', methods: ['GET'])]
    public function show(Vehicules $vehicule): Response
    {
        return $this->render('vehiculescrud/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehiculescrud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicules $vehicule, VehiculesRepository $vehiculesRepository): Response
    {
        $form = $this->createForm(VehiculesType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehiculesRepository->save($vehicule, true);

            return $this->redirectToRoute('app_vehiculescrud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehiculescrud/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehiculescrud_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicules $vehicule, VehiculesRepository $vehiculesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->request->get('_token'))) {
            $vehiculesRepository->remove($vehicule, true);
        }

        return $this->redirectToRoute('app_vehiculescrud_index', [], Response::HTTP_SEE_OTHER);
    }
}
