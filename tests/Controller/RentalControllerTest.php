<?php

namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;

class RentalControllerTest extends PantherTestCase
{
    public function testIndex()
    {
        $client = static::createPantherClient(['external_base_uri' => 'https://127.0.0.1:8000']);
        $client->request('GET', '/');
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        $this->assertSelectorTextContains('h2', 'Choose rental period:');
    }

    public function testFilterOk()
    {
        $client = static::createPantherClient(['external_base_uri' => 'https://127.0.0.1:8000']);

        $dateStart = new \DateTime('+1 day');
        $dateEnd = new \DateTime('+31 day');
        $client->request('GET', '/?from_date=' . $dateStart->format('Y-m-d') .
            '&to_date=' . $dateEnd->format('Y-m-d'));
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        //$this->assertSelectorTextContains('.stock', '1');
        //$this->assertSelectorTextContains('.price', '2,740.50');
        $this->assertSelectorTextContains('.days', '30');

        $client->clickLink('Rent this car now!');
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        $this->assertSelectorTextContains('.days', '30');
    }

    public function testFilterBad()
    {
        $client = static::createPantherClient(['external_base_uri' => 'https://127.0.0.1:8000']);

        $dateStart = new \DateTime('-1 day');
        $dateEnd = new \DateTime('+2 day');
        $client->request('GET', '/?from_date=' . $dateStart->format('Y-m-d') .
            '&to_date=' . $dateEnd->format('Y-m-d'));
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        $this->assertSelectorTextContains('.alert', 'Date start must be after today');

        $dateStart = new \DateTime('-1 day');
        $dateEnd = new \DateTime('-10 day');
        $client->request('GET', '/?from_date=' . $dateStart->format('Y-m-d') .
            '&to_date=' . $dateEnd->format('Y-m-d'));
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        $this->assertSelectorTextContains('.alert', 'Date end must be after date start');
    }

    public function testFormErrors()
    {
        $client = static::createPantherClient(['external_base_uri' => 'https://127.0.0.1:8000']);
        $client->request('GET', '/');
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        $crawler = $client->clickLink('Rent this car now!');
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());

        // test error license expiry date
        $form = $crawler->selectButton('Submit')->form();
        $form['rental_form[first_name]']->setValue('John');
        $form['rental_form[last_name]']->setValue('Doe');
        $form['rental_form[phone]']->setValue('123');
        $form['rental_form[email]']->setValue('john@gmail.com');
        $form['rental_form[drivers_license]']->setValue('11111111');
        $dateExpiry = new \DateTime('-10 day');
        $form['rental_form[drivers_license_expiry]']->setValue($dateExpiry->format('Y-m-d'));

        $client->click($form);
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        $this->assertSelectorTextContains('.invalid-feedback', 'Driving license must be valid through all booking period');
    }

    public function testForm()
    {
        $client = static::createPantherClient(['external_base_uri' => 'https://127.0.0.1:8000']);
        $client->request('GET', '/');
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        $crawler = $client->clickLink('Rent this car now!');
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());

        // test correct rent
        $form = $crawler->selectButton('Submit')->form();
        $form['rental_form[first_name]']->setValue('John');
        $form['rental_form[last_name]']->setValue('Doe');
        $form['rental_form[phone]']->setValue('123');
        $form['rental_form[email]']->setValue('john@gmail.com');
        $form['rental_form[drivers_license]']->setValue('12345678');
        $form['rental_form[drivers_license_expiry]']->setValue('2025-01-15');

        $client->click($form);
        $this->assertSame(200, $client->getInternalResponse()->getStatusCode());
        $this->assertSelectorTextContains('h4', 'Your rental data:');
    }
}