<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Rental;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rental>
 *
 * @method Rental|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rental|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rental[]    findAll()
 * @method Rental[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rental::class);
    }

    public function add(Rental $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Rental $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // get rentals count for period
    public function getRentalsCount($car, $fromDate, $toDate)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(r.id)
                    FROM App\Entity\Rental r
                    WHERE r.car = :car AND ( 
                    (r.date_end>=:date_start AND r.date_end<=:date_end) OR
                    (r.date_start>=:date_start AND r.date_start<=:date_end) OR
                    (r.date_start<=:date_start AND r.date_end>=:date_end)
                    )')
            ->setParameters([
                'car' => $car,
                'date_start' => $fromDate,
                'date_end' => $toDate
            ]);
        return $query->getSingleScalarResult();
    }

    // get customer rentals count
    public function getCustomerRentalsCount(Car $car, Rental $rental)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(r.id)
                    FROM App\Entity\Rental r
                    WHERE r.drivers_license = :license AND ( 
                    (r.date_end>=:date_start AND r.date_end<=:date_end) OR
                    (r.date_start>=:date_start AND r.date_start<=:date_end) OR
                    (r.date_start<=:date_start AND r.date_end>=:date_end)
                    )')
            ->setParameters([
                'license' => $rental->getDriversLicense(),
                'date_start' => $rental->getDateStart(),
                'date_end' => $rental->getDateEnd()
            ]);
        return $query->getSingleScalarResult();
    }

    public function getSeasonPrice($car, $seasons, $fromSeasonDate, $toDate)
    {
        $price = 0;
        do {
            foreach ($seasons as $season) {

                // TODO: need to optimize
                $seasonDateBegin = mktime(0, 0, 0, $season->getFromMonth(), $season->getFromDay(), date('Y'));
                $seasonDateEnd = mktime(23, 59, 59, $season->getToMonth(), $season->getToDay(), $season->getFromMonth() > $season->getToMonth() ? date('Y') + 1 : date('Y'));

                if ($fromSeasonDate->format('U') >= $seasonDateBegin && $fromSeasonDate->format('U') <= $seasonDateEnd) {
                    $price += (float)$car->getSeasonPrice($season->getType());
                    break;
                }
            }

            $fromSeasonDate->modify('+1 day');
        } while ($fromSeasonDate < $toDate);

        return $price;
    }
}
