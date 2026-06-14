<?php

namespace App\Controller;

use App\Entity\Ingenieur;
use App\Form\IngenieurType;
use App\Repository\IngenieurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ingenieur')]
final class IngenieurController extends AbstractController
{
    #[Route(name: 'app_ingenieur_index', methods: ['GET'])]
    public function index(IngenieurRepository $ingenieurRepository): Response
    {
        return $this->render('ingenieur/index.html.twig', [
            'ingenieurs' => $ingenieurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ingenieur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ingenieur = new Ingenieur();
        $form = $this->createForm(IngenieurType::class, $ingenieur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ingenieur);
            $entityManager->flush();

            return $this->redirectToRoute('app_ingenieur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingenieur/new.html.twig', [
            'ingenieur' => $ingenieur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingenieur_show', methods: ['GET'])]
    public function show(Ingenieur $ingenieur): Response
    {
        return $this->render('ingenieur/show.html.twig', [
            'ingenieur' => $ingenieur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ingenieur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ingenieur $ingenieur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IngenieurType::class, $ingenieur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ingenieur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ingenieur/edit.html.twig', [
            'ingenieur' => $ingenieur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingenieur_delete', methods: ['POST'])]
    public function delete(Request $request, Ingenieur $ingenieur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingenieur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ingenieur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ingenieur_index', [], Response::HTTP_SEE_OTHER);
    }
}
