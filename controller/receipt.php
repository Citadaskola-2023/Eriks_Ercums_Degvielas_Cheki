<?php
require __DIR__ . '/../src/LoginSystem.php';
$login = new \App\LoginSystem();
$login->isLoggedIn();
require __DIR__ . '/../src/FuelReceiptInsert.php';

//load header
require '../controller/header.php';

//load form
require '../html/form.html';
$insert = new \App\FuelReceiptInsert();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $insert->uploadFuelReceipt($insert->getFormInput());
}