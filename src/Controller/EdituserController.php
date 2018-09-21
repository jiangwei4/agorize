<?php

namespace App\Controller;

use App\Form\EdituserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EdituserController extends AbstractController
{
    /**
     * @Route("/edituser", name="edituser")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {

        $user = $this->getUser();
        $form = $this->createForm(EdituserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();
            $this->addFlash('notice','les changements ont bien été éffectués');
            return $this->redirectToRoute('home');
        }


        return $this->render('edituser/index.html.twig', [
            'controller_name' => 'EdituserController',
            'form' => $form->createView(),
        ]);
    }
}
