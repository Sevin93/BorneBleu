<?php

namespace App\Controller;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateursController extends AbstractController
{
    #[Route('/utilisateurs', name: 'app_utilisateurs')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('utilisateurs/index.html.twig', [
            'profiles' => $userRepository->findAll(),
        ]);
    }


}
