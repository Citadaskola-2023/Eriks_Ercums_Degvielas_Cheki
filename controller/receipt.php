<?php

require __DIR__ . '/../src/FuelReceiptDTO.php';
require __DIR__ . '/../src/FuelReceiptInsert.php';
require __DIR__ . "/../src/FuelReceiptRequest.php";

//load html
require '../html/receiptData.html';

//receive data
$request = new \App\FuelReceiptRequest();
echo "<div class='table'>";
$request->requestData();
echo "</div>";

//send data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receipt = new \App\FuelReceiptDTO(
        licencePlate: $_POST['license_plate'],
        dateTime: $_POST['date_time'],
        odometer: $_POST['odometer'],
        petrolStation: $_POST['petrol_station'],
        fuelType: $_POST['fuel_type'],
        refueled: $_POST['refueled'],
        total: $_POST['total'],
        currency: $_POST['currency'],
    );

    $receiptUpload = new \App\FuelReceiptInsert();
    $receiptUpload->uploadFuelReceipt($receipt->toArray());

    echo "<h3> RECEIPT DATA WAS ADD TO THE DATABASE";
}

//form
require '../html/receiptForm.html';