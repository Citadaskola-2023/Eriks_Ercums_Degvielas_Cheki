<?php

namespace App;

use PDO;
class FuelReceiptInsert
{
    private \PDO $pdo;
    private function connectDB() : \PDO{
        $conn = new PDO('localhost', 'root', 'root', 'myapp');
        if($conn->connect_error){
            die('Connection to database failed : ' . $conn->connect_error);
        }
        else{
            return $conn;
        }
    }
    public function uploadFuelReceipt(array $data) : void{
        $conn = $this->connectDB();
        $conn->prepare("INSERT INTO Form(license_plate, date_time,
         petrol_station, fuel_type, refueled, total, currency, fuel_price, odometer)
         VALUES(" . impolde(",", $data) . ")")->execute();
        $conn->close();
    }
}