<?php
    require __DIR__ . '/../src/LoginSystem.php';
    $login = new \App\LoginSystem();
    echo '
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fuel Receipt Form</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<header>
  <a href="../receipt?">Receipt</a>
  <a href="../data?">Data</a>
  <a href='.
    $login->logout().'>Logout</a>
</header>
</html>
'
?>
