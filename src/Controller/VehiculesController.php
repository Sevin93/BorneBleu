<?php

namespace App\Controller;
use App\Repository\AffectationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculesController extends AbstractController
{
    #[Route('/vehicules', name: 'app_vehicules')]
    public function index(): Response
    {
        return $this->render('vehicules/index.html.twig', [
            'controller_name' => 'VehiculesController',
        ]);
    }

    #[Route('/monvehicule', name: 'app_monvehicule')]
    public function monvehicule(AffectationRepository $affectationRepository): Response
    {
        if ($this->getUser()){
            $user=$this->getUser();
            $affectation=$affectationRepository->findOneBy(['user'=>$user]);
            
        }
        return $this->render('vehicules/monvehicule.html.twig', [
            'affectation' => $affectation,
        ]);
    }
    
}
