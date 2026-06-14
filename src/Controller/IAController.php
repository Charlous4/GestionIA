<?php

namespace App\Controller;

use App\Entity\IA;
use App\Form\IAType;
use App\Repository\IARepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ia')]
final class IAController extends AbstractController
{
    #[Route(name: 'app_ia_index', methods: ['GET'])]
    public function index(IARepository $iARepository): Response
    {
        return $this->render('ia/index.html.twig', [
            'ias' => $iARepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ia_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ium = new IA();
        $form = $this->createForm(IAType::class, $ium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ium);
            $entityManager->flush();

            return $this->redirectToRoute('app_ia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ia/new.html.twig', [
            'ium' => $ium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ia_show', methods: ['GET'])]
    public function show(IA $ium): Response
    {
        return $this->render('ia/show.html.twig', [
            'ium' => $ium,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ia_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, IA $ium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IAType::class, $ium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ia/edit.html.twig', [
            'ium' => $ium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ia_delete', methods: ['POST'])]
    public function delete(Request $request, IA $ium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ium->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ia_index', [], Response::HTTP_SEE_OTHER);
    }
}
