<?php

require __DIR__ . '/../src/UserManager.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userManager = new \App\UserManager();
    if($userManager->login($_POST['username'], $_POST['password'])){
        require '../controller/receipt.php';
    }
    echo "Login failed...";
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
<h1>Login</h1>
<form method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="text" name="password"><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>
