<?php

require __DIR__ . '/../src/FuelReceiptDTO.php';
require __DIR__ . '/../src/FuelReceiptInsert.php';

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Receipt Form</title>
    <link href="../public/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<h1>Fuel Receipt Form</h1>
<form method="post">
    License Plate: <input type="text" name="license_plate"><br>
    Date and Time: <input type="datetime-local" name="date_time"><br>
    Petrol Station: <input type="text" name="petrol_station"><br>
    Fuel Type: <input type="text" name="fuel_type"><br>
    Refueled (liters): <input type="number" name="refueled"><br>
    Total (currency): <input type="number" name="total"><br>
    Currency: <select type="text" name="currency">
        <option value="USD">United States Dollar (USD)</option>
        <option value="EUR">Euro (EUR)</option>
        <option value="GBP">British Pound (GBP)</option>
        <option value="JPY">Japanese Yen (JPY)</option>
        <option value="CAD">Canadian Dollar (CAD)</option>
        <option value="CHF">Swiss Franc (CHF)</option>
        <option value="AUD">Australian Dollar (AUD)</option>
        <option value="HKD">Hong Kong Dollar (HKD)</option>
        <option value="NZD">New Zealand Dollar (NZD)</option>
        <option value="SEK">Swedish Krona (SEK)</option>
        <option value="NOK">Norwegian Krone (NOK)</option>
        <option value="DKK">Danish Krone (DKK)</option>
        <option value="THB">Thai Baht (THB)</option>
        <option value="INR">Indian Rupee (INR)</option>
        <option value="CNY">Chinese Yuan (CNY)</option>
        <option value="SGD">Singapore Dollar (SGD)</option>
        <option value="TWD">New Taiwan Dollar (TWD)</option>
        <option value="KRW">South Korean Won (KRW)</option>
        <option value="MXN">Mexican Peso (MXN)</option>
        <option value="BRL">Brazilian Real (BRL)</option>
        <option value="ZAR">South African Rand (ZAR)</option>
    </select><br>
    Fuel Price: <input type="number" step="0.01" name="fuel_price"><br>

    Odometer: <input type="number" name="odometer"><br>
    <input type="submit" value="Submit">
</form>

<div>

</div class="table">

</body>
</html>

