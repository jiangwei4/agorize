<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
      if  ($this->getUser() != null && in_array("ROLE_USER",$this->getUser()->getRoles()) ){
          return $this->render('home/index.html.twig', [
              'controller_name' => 'img/netflix.png',
          ]);
      } else {
          return $this->redirect($this->generateUrl('signin'));
      }
    }
}
