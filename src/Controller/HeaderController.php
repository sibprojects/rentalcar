<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HeaderController extends AbstractController
{
    private $twig;
    private $cars;

    public function __construct(Environment $twig, CarRepository $carRepository)
    {
        $this->twig = $twig;
        $this->cars = $carRepository->findAll();
    }

    /**
    + * @Route("/rental_header/{id}", name="rental_header")
    + */
    public function rentalHeader($id)
    {
        return new Response($this->twig->render('rental/header.html.twig',
            [
                'cars' => $this->cars,
                'id' => $id,
            ]));
    }
}
