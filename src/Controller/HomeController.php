<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use App\Repository\IARepository;
use App\Repository\EditeurRepository;
use App\Repository\VersionRepository;
use App\Repository\IngenieurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        TicketRepository    $ticketRepo,
        IARepository        $iaRepo,
        EditeurRepository   $editeurRepo,
        VersionRepository   $versionRepo,
        IngenieurRepository $ingenieurRepo,
    ): Response {
        $allTickets = $ticketRepo->findAll();
        
        $tickets_recents = $ticketRepo->findBy(
        [], 
        ['createAt' => 'DESC'], 
        5
        );

        return $this->render('home/index.html.twig', [
            'tickets_total'      => count($allTickets),
            'tickets_prioritaires' => count(array_filter($allTickets, fn($t) => $t->isPriorite())),
            'tickets_normaux'    => count(array_filter($allTickets, fn($t) => !$t->isPriorite())),
            'tickets_recents'      => $tickets_recents,
            'ias'                => $iaRepo->findAll(),
            'nb_ia'              => count($iaRepo->findAll()),
            'nb_editeurs'        => count($editeurRepo->findAll()),
            'versions_recentes'  => array_slice($versionRepo->findAll(), 0, 5),
            'ingenieurs'         => $ingenieurRepo->findAll(),
        ]);
    }
}