<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$routes = [
        '/' => '../controller/login.php',
        '/receipt' => '../controller/receipt.php',
        '/data' => '../controller/data.php'
];

if(array_key_exists($uri, $routes)){
    require $routes[$uri];
}
else{
    echo "404 try again..." . "<br>";
}