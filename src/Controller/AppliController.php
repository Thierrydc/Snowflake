<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppliController extends AbstractController
{
    /**
     * @Route("/", name="app_appli_index")
     */
    public function index(): Response
    {
        return $this->render('appli/index.html.twig', []);
    }

    /**
     * @Route("/random", name="app_appli_random")
     */
    public function random(): Response
    {
        $number = random_int(0, 100);

        return $this->render('appli/random.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/random/{mynumber}", name="app_appli_mynumber")
     */
    public function mynumber(int $mynumber): Response
    {
        $number = $mynumber;

        return $this->render('appli/random.html.twig', [
            'number' => $number,
        ]);
    }
}
