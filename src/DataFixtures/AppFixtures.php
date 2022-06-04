<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // add seasons
        $season = new Season();
        $season->setType('low');
        $season->setFromDay(1);
        $season->setFromMonth(6);
        $season->setToDay(15);
        $season->setToMonth(9);
        $manager->persist($season);

        $season = new Season();
        $season->setType('mid');
        $season->setFromDay(15);
        $season->setFromMonth(9);
        $season->setToDay(31);
        $season->setToMonth(10);
        $manager->persist($season);

        $season = new Season();
        $season->setType('mid');
        $season->setFromDay(1);
        $season->setFromMonth(3);
        $season->setToDay(1);
        $season->setToMonth(6);
        $manager->persist($season);

        $season = new Season();
        $season->setType('high');
        $season->setFromDay(1);
        $season->setFromMonth(10);
        $season->setToDay(1);
        $season->setToMonth(3);
        $manager->persist($season);
        
        // add cars
        $car = new Car();
        $car->setBrand('Seat');
        $car->setModel('León');
        $car->setStock(3);
        $car->setPriceSeasonHigh(98.43);
        $car->setPriceSeasonMid(76.89);
        $car->setPriceSeasonLow(53.65);
        $manager->persist($car);

        $car = new Car();
        $car->setBrand('Seat');
        $car->setModel('Ibiza');
        $car->setStock(5);
        $car->setPriceSeasonHigh(85.12);
        $car->setPriceSeasonMid(65.73);
        $car->setPriceSeasonLow(46.85);
        $manager->persist($car);

        $car = new Car();
        $car->setBrand('Nissan');
        $car->setModel('Qashqai');
        $car->setStock(2);
        $car->setPriceSeasonHigh(101.46);
        $car->setPriceSeasonMid(82.94);
        $car->setPriceSeasonLow(59.87);
        $manager->persist($car);

        $car = new Car();
        $car->setBrand('Jaguar');
        $car->setModel('E-pace');
        $car->setStock(1);
        $car->setPriceSeasonHigh(120.54);
        $car->setPriceSeasonMid(91.35);
        $car->setPriceSeasonLow(70.27);
        $manager->persist($car);

        $car = new Car();
        $car->setBrand('Mercedes');
        $car->setModel('Vito');
        $car->setStock(2);
        $car->setPriceSeasonHigh(109.16);
        $car->setPriceSeasonMid(89.64);
        $car->setPriceSeasonLow(64.97);
        $manager->persist($car);

        $manager->flush();
    }
}
