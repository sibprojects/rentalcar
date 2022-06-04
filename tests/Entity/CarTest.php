<?php

namespace App\Tests\Entity;

use App\Entity\Car;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Car();
    }

    public function testCar(): void
    {
        $this->assertNull($this->object->getId());

        $this->object->setBrand("Lexus");
        $this->assertEquals("Lexus", $this->object->getBrand());

        $this->object->setModel("RX450h");
        $this->assertEquals("RX450h", $this->object->getModel());

        $this->object->setStock("12");
        $this->assertEquals("12", $this->object->getStock());

        $this->object->setPriceSeasonHigh("1000");
        $this->assertEquals("1000", $this->object->getPriceSeasonHigh());

        $this->object->setPriceSeasonMid("800");
        $this->assertEquals("800", $this->object->getPriceSeasonMid());

        $this->object->setPriceSeasonLow("300");
        $this->assertEquals("300", $this->object->getPriceSeasonLow());

        $this->object->setPrice("567");
        $this->assertEquals("567", $this->object->getPrice());

        $this->object->setAveragePrice("56");
        $this->assertEquals("56", $this->object->getAveragePrice());
    }
}
