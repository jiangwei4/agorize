<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\CreateprojetType;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateprojetsController extends AbstractController
{
    /**
     * @Route("/projets_create", name="projets_create")
     */
    public function index(Request $request, ProjetRepository $projetRepository, EventDispatcherInterface $eventDispatcher)
    {
        $user = $this->getUser();
        $projet = new Projet();
        $form = $this->createForm(CreateprojetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();
            $this->addFlash('notice', 'vidéo crée');
            // $event = new MovieRegisteredEvent($projet);
            // $eventDispatcher->dispatch(MovieRegisteredEvent::NAME,$event);
            return $this->redirectToRoute('home');
        }

        return $this->render('createprojets/index.html.twig', [
            'controller_name' => 'CreateprojetController',
            'form' => $form->createView(),
        ]);
    }
}
