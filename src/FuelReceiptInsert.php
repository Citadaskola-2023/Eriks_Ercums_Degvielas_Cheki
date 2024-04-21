<?php

namespace App;
use PDO;

class FuelReceiptInsert
{
    private function connectDB() : PDO{
        $conn = new PDO(
            dsn: 'mysql:host=localhost;dbname=myapp',
            username: 'root',
            password: 'root');
        return $conn;
    }
    public function uploadFuelReceipt(array $data) : void{
        $conn = $this->connectDB();
        /*$stmt = $conn->prepare("INSERT INTO Form(license_plate, date_time,
         petrol_station, fuel_type, refueled, total, currency, fuel_price, odometer)
         VALUES(:license_plate, :date_time, :petrol_station, :fuel_type, :refueled, :total, :currency, :fuel_price, :odometer)");
        $stmt->execute($data);*/
    }
}