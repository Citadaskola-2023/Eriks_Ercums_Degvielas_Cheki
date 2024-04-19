<?php

namespace App;

class FuelReceiptDTO
{
    public function __construct(
        public string $licencePlate,
        public string $dateTime,
        public string $petrolStation,
        public string $refueled,
        public string $total,
        public string $currency,
        public string $fuelPrice,
        public string $odometer
    )
    {
        var_dump($this);
        die;
    }
}