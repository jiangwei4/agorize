<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\EditprojetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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

    /**
     * @Route("/listprojet/remove/{id}", name="listprojet_remove")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function remove(Projet $projet, EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $entityManager->remove($projet);
        $entityManager->flush();
        $this->addFlash('notice', 'projet supprimée');
       // $event = new MovieRemovedEvent($movie);
       // $eventDispatcher->dispatch(MovieRemovedEvent::NAME,$event);
        return $this->redirectToRoute('projets');
    }

    /**
     * @Route("/listprojet/edite/{id}", name="listprojet_edite")
     * @ParamConverter("projet", options={"mapping"={"id"="id"}})
     */
    public function edit(\Symfony\Component\HttpFoundation\Request $request,EntityManagerInterface $entityManager,
                         ProjetRepository $projetRepository, int $id)
    {

        $projet = $projetRepository->find($id);
        $form = $this->createForm(EditprojetType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($projet);
            $entityManager->flush();
            $this->addFlash('notice', 'Changement(s) effectué(s)!');

            return $this->redirectToRoute('projets');
        }

        return $this->render('projets_liste/editprojet.html.twig', [
            'controller_name' => 'EditprojetController',
            'form' => $form->createView(),
        ]);
    }
}
