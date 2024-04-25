<?php

namespace App;

require __DIR__ . '/../src/DB.php';

class FuelReceiptInsert
{
    public function uploadFuelReceipt(array $data) : void{
        $DB = new DB();
        $conn = $DB->connectDB();
        $stmt = $conn->prepare("INSERT INTO Form(licence_plate, date_time,
         petrol_station, fuel_type, refueled, total, currency, fuel_price, odometer)
         VALUES(:licence_plate, :date_time, :petrol_station, :fuel_type, :refueled, :total, :currency, :fuel_price, :odometer)");
        $stmt->execute($data);
    }
}