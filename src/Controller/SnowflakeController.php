<?php

namespace App\Controller;

use App\Entity\Snowflake;
use App\Form\SnowflakeFormType;
use App\Repository\SnowflakeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnowflakeController extends AbstractController
{
    /**
     * @Route("/snowflakes", name="appli_snowflake_index")
     */
    public function index(SnowflakeRepository $snowflakeRepository): Response
    {
        $snowflakes = $snowflakeRepository->findAll();

        return $this->render('snowflake/index.html.twig', [
            'snowflakes' => $snowflakes,
        ]);
    }

    /**
     * @Route("/snowflake/{id<\d+>}", name="appli_snowflake_show")
     */
    public function show(int $id, SnowflakeRepository $snowflakeRepository): Response
    {
        $snowflake = $snowflakeRepository->find($id);

        if (!$snowflake) {
            throw $this->createNotFoundException(
                'No snowflake found for id '.$id
            );
        }

        return $this->render('snowflake/show.html.twig', [
            'snowflake' => $snowflake,
        ]);
    }

    /**
     * @Route("/snowflakes/create", name="appli_snowflake_create")
     */
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $entity = new Snowflake();
        $form = $this->createForm(SnowflakeFormType::class, $entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', 'Le Snowflake a bien été créé.');

            return $this->redirectToRoute('appli_snowflake_index');
        }

        return $this->render('snowflake/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
