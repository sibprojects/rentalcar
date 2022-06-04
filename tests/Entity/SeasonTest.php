<?php

namespace App\Tests\Entity;

use App\Entity\Season;
use PHPUnit\Framework\TestCase;

class SeasonTest extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Season();
    }

    public function testSeason(): void
    {
        $this->assertNull($this->object->getId());

        $this->object->setType("mid");
        $this->assertEquals("mid", $this->object->getType());

        $this->object->setFromMonth("5");
        $this->assertEquals("5", $this->object->getFromMonth());

        $this->object->setFromDay("2");
        $this->assertEquals("2", $this->object->getFromDay());

        $this->object->setToMonth("10");
        $this->assertEquals("10", $this->object->getToMonth());

        $this->object->setToDay("8");
        $this->assertEquals("8", $this->object->getToDay());
    }
}
