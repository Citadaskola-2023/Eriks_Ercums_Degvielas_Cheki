<?php

namespace App;

class FuelReceiptDTO
{
    public function __construct(
        public string $licencePlate,
        public string $dateTime,
        public string $odometer,
        public string $petrolStation,
        public string $fuelType,
        public string $refueled,
        public string $total,
        public string $currency,
    )
    {
    }

    private function getFuelPrice(): float
    {
        return $this->total / $this->refueled;
    }

    public function toArray(): array
    {
        return [
            'licence_plate' => $this->licencePlate,
            'date_time' => $this->dateTime,
            'petrol_station' => $this->petrolStation,
            'fuel_type' => $this->fuelType,
            'refueled' => $this->refueled,
            'total' => $this->total,
            'currency' => $this->currency,
            'fuel_price' => $this->getFuelPrice(),
            'odometer' => $this->odometer,
        ];
    }

}