<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/serie', name: 'serie')]
final class SerieController extends AbstractController
{

    #[Route('/list/{page}', name: '_list', requirements: ['page' => '\d+'], defaults: ['page' => 1], methods: ['GET'])]
    public function list(SerieRepository $serieRepository, int $page): Response
    {
        $series = $serieRepository->findAll();

        $series = $serieRepository->findBy(
            [
            'status' => 'Returning',
            'genre' => 'Drama',
            ],
        [
            'popularity' => 'DESC',
        ],
            limit: 10,
            offset: 0
        );

        return $this->render('serie/list.html.twig', [
            'series' => $series
        ]
        );

    }

    #[Route('/detail/{id}', name: '_detail')]
    public function detail(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException('Pas de série pour cet id');
        }

        return $this->render('serie/detail.html.twig', [
            'serie' => $serie
        ]);
    }

}