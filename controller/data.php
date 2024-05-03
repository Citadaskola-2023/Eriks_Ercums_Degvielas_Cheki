<?php

//load header
require '../html/header.html';

require __DIR__ . '/../src/FuelReceiptRequest.php';

//get search
require '../html/data.html';
$request = new \App\FuelReceiptRequest();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $request->getSearchInputs();
}
