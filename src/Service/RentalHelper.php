<?php

namespace App\Service;

class RentalHelper
{
    public function checkDates($fromDate, $toDate): ?string
    {
        $searchError = '';
        $now = new \DateTime();
        if ($fromDate->format('U') - $now->format('U') <= 0) {
            $searchError = 'Date start must be after today';
        }
        if ($toDate->format('U') - $fromDate->format('U') <= 0) {
            $searchError = 'Date end must be after date start';
        }
        return $searchError;
    }
}