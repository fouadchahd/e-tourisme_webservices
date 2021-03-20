<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PoiController extends AbstractController
{
    /**
     * @Route("/poi", name="poi")
     */
    public function index(): Response
    {
        return $this->render('poi/index.html.twig', [
            'controller_name' => 'PoiController',
        ]);
    }
}
