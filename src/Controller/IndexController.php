<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\RentalRepository;
use App\Repository\SeasonRepository;
use App\Service\RentalHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class IndexController extends AbstractController
{
    private $twig;
    private $entityManager;
    private $seasons;
    private $cars;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager,
                                CarRepository $carRepository, SeasonRepository $seasonRepository)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;

        $this->seasons = $seasonRepository->findAll();
        $this->cars = $carRepository->findAll();
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, RentalRepository $rentalRepository, RentalHelper $rentalHelper): Response
    {
        $cars = $this->cars;

        $searchError = '';
        $filter = null;
        $daysCount = 1;
        if($request->get('from_date')){

            $filter = true;
            $fromDate = \DateTime::createFromFormat('Y-m-d', $request->get('from_date'));
            $toDate = \DateTime::createFromFormat('Y-m-d', $request->get('to_date'));
            $daysCount = $toDate->diff($fromDate)->format("%a");

            $searchError = $rentalHelper->checkDates($fromDate, $toDate);

            if(!$searchError) {

                $cars = [];
                foreach ($this->cars as $car) {

                    // calc availability
                    $rentsCount = $rentalRepository->getRentalsCount($car, $fromDate, $toDate);
                    if ($car->getStock() - $rentsCount > 0) {
                        $car->setStock($car->getStock() - $rentsCount);
                        $cars[] = $car;
                    }

                    // calc full price
                    $fromSeasonDate = \DateTime::createFromFormat('Y-m-d', $request->get('from_date'));
                    $price = $rentalRepository->getSeasonPrice($car, $this->seasons, $fromSeasonDate, $toDate);
                    $car->setPrice($price);
                    $car->setAveragePrice($price / $daysCount);
                }

                if (!count($cars)) {
                    $searchError = 'Available cars not found! Try to set another dates.';
                }
            }
        }

        return new Response($this->twig->render('rental/index.html.twig', [
            'cars' => $cars,
            'filter' => $filter,
            'daysCount' => $daysCount,
            'searchError' => $searchError,
        ]));
    }
}
