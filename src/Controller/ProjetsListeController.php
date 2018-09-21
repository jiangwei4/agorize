<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProjetsListeController extends AbstractController
{
    /**
     * @Route("/projets", name="projets")
     */
    public function index(ProjetRepository $projetRepository)
    {

        $user = $this->getUser();
        $projets = $projetRepository->findBy(['user'=>$user]);

        return $this->render('projets_liste/index.html.twig', [
            'controller_name' => 'projetsListe',
            'projets' => $projets,
        ]);
    }
}
