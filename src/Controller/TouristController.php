<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TouristController extends AbstractController
{
    /**
     * @Route("/tourist", name="tourist")
     */
    public function index(): Response
    {
        return $this->render('tourist/index.html.twig', [
            'controller_name' => 'TouristController',
        ]);
    }
}
