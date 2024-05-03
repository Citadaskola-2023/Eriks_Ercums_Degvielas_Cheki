<?php

require __DIR__ . '/../src/FuelReceiptInsert.php';

//load header
require '../html/header.html';

//load form
require '../html/form.html';
$insert = new \App\FuelReceiptInsert();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $insert->uploadFuelReceipt($insert->getFormInput());
}