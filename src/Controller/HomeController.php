<?php

namespace App\Controller;
use App\Repository\PlanningRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomeController extends AbstractController
{
   public function __construct(private PlanningRepository $planningRepository){
       

   }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $lastPlanning=$this->planningRepository->findClosesDate($this->getUser());
        
       
        return $this->render('home/index.html.twig', [
            'planning'=>$lastPlanning,
            'controller_name' => 'HomeController',
        ]);
    }
    
    
}
