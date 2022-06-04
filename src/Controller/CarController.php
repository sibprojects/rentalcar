<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Rental;
use App\Form\RentalFormType;
use App\Repository\CarRepository;
use App\Repository\RentalRepository;
use App\Repository\SeasonRepository;
use App\Service\RentalHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class CarController extends AbstractController
{
    private $twig;
    private $entityManager;
    private $seasons;
    private $session;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager,
                                SeasonRepository $seasonRepository)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;

        $this->seasons = $seasonRepository->findAll();

        $session = new Session();
        $session->start();
        $this->session = $session;
    }

    /**
     * @Route("/car/{id}", name="car")
     */
    public function car(Request $request, Car $car, NotifierInterface $notifier, RentalRepository $rentalRepository, RentalHelper $rentalHelper): Response
    {
        $rental = new Rental();
        $form = $this->createForm(RentalFormType::class, $rental);

        $daysCount = 1;
        if ($request->get('rental_form')) {
            $fromDate = \DateTime::createFromFormat('Y-m-d', $request->get('rental_form')['date_start']);
            $toDate = \DateTime::createFromFormat('Y-m-d', $request->get('rental_form')['date_end']);
            $daysCount = $toDate->diff($fromDate)->format("%a");
            $fromSeasonDate = \DateTime::createFromFormat('Y-m-d', $request->get('rental_form')['date_start']);
        } elseif ($request->get('from_date')) {
            $form->get('date_start')->setData(\DateTime::createFromFormat('Y-m-d', $request->get('from_date')));
            $form->get('date_end')->setData(\DateTime::createFromFormat('Y-m-d', $request->get('to_date')));
            $fromDate = \DateTime::createFromFormat('Y-m-d', $request->get('from_date'));
            $toDate = \DateTime::createFromFormat('Y-m-d', $request->get('to_date'));
            $daysCount = $toDate->diff($fromDate)->format("%a");
            $fromSeasonDate = \DateTime::createFromFormat('Y-m-d', $request->get('from_date'));
        } else {
            $form->get('date_start')->setData(new \DateTime('+1 day'));
            $form->get('date_end')->setData(new \DateTime('+2 day'));
            $fromDate = new \DateTime('+1 day');
            $toDate = new \DateTime('+2 day');
            $fromSeasonDate = new \DateTime();
        }

        $searchError = $rentalHelper->checkDates($fromDate, $toDate);

        if(!$searchError) {

            // get rentals count for period
            $rentsCount = $rentalRepository->getRentalsCount($car, $fromDate, $toDate);

            // calc availability
            $car->setStock($car->getStock() - $rentsCount);
            if ($car->getStock() <= 0) {
                $searchError = 'This car is not available for period: '.$fromDate->format('Y-m-d').' - '.
                    $toDate->format('Y-m-d').'! Please, select another dates or choose another car to rent!';
            }

            // calc full price
            $price = $rentalRepository->getSeasonPrice($car, $this->seasons, $fromSeasonDate, $toDate);
            $car->setPrice($price);
            $car->setAveragePrice($price / $daysCount);

            $form->handleRequest($request);

            // check only one booking on the same dates
            if (!$searchError && $form->isSubmitted() && $form->isValid()) {
                $customerRentalsCount = $rentalRepository->getCustomerRentalsCount($car, $rental);
                if ($customerRentalsCount > 0) {
                    $searchError = 'Sorry, you can has only one booking on the same dates!';
                }
            }

            if (!$searchError && $form->isSubmitted() && $form->isValid()) {
                $rental->setAmount($car->getPrice());
                $rental->setCar($car);
                $this->entityManager->persist($rental);
                $this->entityManager->flush();

                $notifier->send(new Notification('Your rent request is done!', ['browser']));

                $this->session->set('rental_id', $rental->getId());
                return $this->redirectToRoute('car-rented', ['id' => $rental->getId()]);
            }
        }

        return new Response($this->twig->render('rental/car.html.twig', [
            'car' => $car,
            'rental_form' => $form->createView(),
            'daysCount' => $daysCount,
            'searchError' => $searchError,
        ]));
    }
}
