<?php
require_once '../src/LoginSystem.php';
$loginSystem = new \App\LoginSystem();
$loginSystem->isLoggedIn();
//load header
require '../controller/header.php';

require __DIR__ . '/../src/FuelReceiptRequest.php';

//get search
require '../html/data.html';
$request = new \App\FuelReceiptRequest();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $request->getSearchInputs();
}
