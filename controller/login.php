<?php
require __DIR__ . '/../src/LoginSystem.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginSystem = new \App\LoginSystem();
    if ($loginSystem->login($_POST['username'], $_POST['password'])) {
        header("Location: /receipt");
        exit;
    } else {
        echo "<h3> WRONG USERNAME OR PASSWORD </h3>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Receipt Form</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<h1>Login</h1>
<form method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="text" name="password"><br>
    <input value="submit" type="submit">
</form>
</body>
</html>
