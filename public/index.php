<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$routes = [
        '/' => '../controller/landing.php',
        '/login' => '../controller/login.php',
        '/signup' => '../controller/signup.php',
        '/receipt' => '../controller/receipt.php'
];

if(array_key_exists($uri, $routes)){
    require $routes[$uri];
}
else{
    echo "No page found..." . "<br>";
}