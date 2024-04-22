<?php

namespace App;
use PDO;
use PDOException;

class FuelReceiptInsert
{
    private function connectDB() : PDO{
        try{
            return new \PDO(
                'mysql:host=mysql;dbname=myapp;',
                'root',
                'root',
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        }
        catch (PDOException $e){
            echo $e->getCode() . " " . $e->getMessage() . '<br>';
            die("Shit went tits up...");
        }
    }
    public function uploadFuelReceipt(array $data) : void{
        $conn = $this->connectDB();
        $stmt = $conn->prepare("INSERT INTO Form(licence_plate, date_time,
         petrol_station, fuel_type, refueled, total, currency, fuel_price, odometer)
         VALUES(:licence_plate, :date_time, :petrol_station, :fuel_type, :refueled, :total, :currency, :fuel_price, :odometer)");
        $stmt->execute($data);
    }
}