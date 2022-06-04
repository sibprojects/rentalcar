<?php

namespace App\Tests\Entity;

use App\Entity\Car;
use App\Entity\Rental;
use PHPUnit\Framework\TestCase;

class RentalTest extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Rental();
        $this->car = new Car();
    }

    public function testRental(): void
    {
        $this->car->setBrand("Lexus");
        $this->car->setModel("RX450h");
        $this->car->setStock("12");
        $this->car->setPriceSeasonHigh("1000");
        $this->car->setPriceSeasonMid("800");
        $this->car->setPriceSeasonLow("300");

        $this->assertNull($this->object->getId());

        $this->object->setCar($this->car);
        $this->assertEquals($this->car, $this->object->getCar());

        $date = new \DateTime();
        $this->object->setDateCreate($date);
        $this->assertEquals($date, $this->object->getDateCreate());

        $this->object->setDateStart($date);
        $this->assertEquals($date, $this->object->getDateStart());

        $this->object->setDateEnd($date);
        $this->assertEquals($date, $this->object->getDateEnd());

        $this->object->setFirstName("John");
        $this->assertEquals("John", $this->object->getFirstName());

        $this->object->setLastName("Doe");
        $this->assertEquals("Doe", $this->object->getLastName());

        $this->object->setPhone("+555-66-77");
        $this->assertEquals("+555-66-77", $this->object->getPhone());

        $this->object->setEmail("john.doe@gmail.com");
        $this->assertEquals("john.doe@gmail.com", $this->object->getEmail());

        $this->object->setDriversLicense("5556677");
        $this->assertEquals("5556677", $this->object->getDriversLicense());

        $this->object->setDriversLicenseExpiry($date);
        $this->assertEquals($date, $this->object->getDriversLicenseExpiry());
    }
}
