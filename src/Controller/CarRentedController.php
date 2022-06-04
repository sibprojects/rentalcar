<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Rental;
use App\Repository\CarRepository;
use App\Repository\RentalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CarRentedController extends AbstractController
{
    private $twig;
    private $session;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

        $session = new Session();
        $session->start();
        $this->session = $session;
    }

    /**
     * @Route("/car-rented/{id}", name="car-rented")
     */
    public function carRented(Request $request, Rental $rental, CarRepository $carRepository): Response
    {
        $rental_id = $this->session->get('rental_id');
        if($rental_id!=$rental->getId()){
            return $this->redirectToRoute('home');
        }

        $car = $rental->getCar();

        $fromDate = $rental->getDateStart();
        $toDate = $rental->getDateEnd();
        $daysCount = $toDate->diff($fromDate)->format("%a");

        return new Response($this->twig->render('rental/carRented.html.twig', [
            'car' => $car,
            'rental' => $rental,
            'daysCount' => $daysCount,
        ]));
    }
}
