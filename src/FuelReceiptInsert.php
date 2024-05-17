<?php

namespace App;

use DateTime;
use DateTimeZone;

require __DIR__ . '/../src/DB.php';

class FuelReceiptInsert
{
    private const array currency = ['USD', 'EUR', 'GBP', 'JPY', 'CAD', 'CHF', 'AUD', 'HKD', 'NZD', 'SEK',
    'NOK', 'DKK', 'THB', 'INR', 'CNY', 'SGD', 'TWD', 'KRW', 'MXN', 'BBL', 'ZAR'];
    public function getFormInput(): array
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $data =  [
                'licence_plate' => $_POST['license_plate'],
                'date_time' => $_POST['date_time'],
                'petrol_station' => $_POST['petrol_station'],
                'fuel_type' => $_POST['fuel_type'],
                'refueled' => $_POST['refueled'],
                'currency' => $_POST['currency'],
                'fuel_price' => $_POST['fuel_price'],
                'odometer' => $_POST['odometer'],
                'total' => ''
            ];
            //Convert time zone
            if(empty($data['date_time'])){
                die("No date entered");
            }
            $localDT = new DateTime($data['date_time'], new DateTimeZone(date_default_timezone_get()));
            $localDT->setTimezone(new DateTimeZone('UTC'));
            $utcDT = $localDT->format('Y-m-d\TH:i');
            $data['date_time'] = $utcDT;;

            //Banned word check
            if(!$this->checkBannedWords($data)){
                die("Contains banned words");
            }
            //Licence plate
            if(!is_string($data['licence_plate'])){
                die("Wrong input: Licence plate");
            }
            //Date time
            if(!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $data['date_time'])){
                die("Wrong input: Date time");
            }
            //Petrol station
            if(!is_string($data['petrol_station'])){
                die("Wrong input: Petrol station");
            }
            //Fuel type
            if(!is_string($data['fuel_type'])){
                die("Wrong input: Fuel type");
            }
            //Refueled
            if(!preg_match('/^\d+(\.\d+)?$/', $data['refueled'])){
                die("Wrong input: Refueled");
            }
            //Currency
            $curMatch = false;
            foreach(self::currency as $cur){
                if($data['currency'] == $cur){
                    $curMatch = true;
                    break;
                }
            }
            if(!$curMatch){
                die("Wrong input: Currency");
            }
            //Fuel price
            if(!preg_match('/^\d+(\.\d+)?$/', $data['fuel_price'])){
                die("Wrong input: Fuel price");
            }
            //Odometer
            if(!preg_match('/^[0-9]+$/', $data['odometer'])){
                die("Wrong input: Odometer");
            }
            $data['total'] = $data['fuel_price'] * $data['refueled'];
            return $data;
        }
        die("<h3> Could not get form input data </h3>");
    }
    public function checkBannedWords(array $input) : bool{
        $db = new DB();
        foreach($input as $data){
            foreach ($db::bannedWords as $bw) {
                if (stristr($data, $bw)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function uploadFuelReceipt(array $data) : void{
        $DB = new DB();
        $conn = $DB->connectDB();
        $stmt = $conn->prepare("INSERT INTO Form(licence_plate, date_time,
         petrol_station, fuel_type, refueled, currency, fuel_price, odometer, total)
         VALUES(:licence_plate, :date_time, :petrol_station, :fuel_type, :refueled, :currency, :fuel_price, :odometer, :total)");
        $stmt->execute($data);
    }
}