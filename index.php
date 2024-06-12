<?php

//Define routes
$routes = [
    ['POST','/register','controllers/register.php'],
    ['POST','/verify','controllers/verify.php'],
    ['POST','/login','controllers/login.php'],
    ['GET','/','controllers/home.php'],
    ['POST','/sync','controllers/sync.php'],
    ['POST','/syncDown','controllers/syncDown.php'],
    ['GET','/404','controllers/404.php']
];

//A simple router
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri);
$uri = $uri[0];

//Find the route and method that matches the request, otherwise return 404
foreach ($routes as $route) {
    if ($route[1] === $uri && $route[0] === $_SERVER['REQUEST_METHOD']) {
        require $route[2];
        exit;
    }
}

require 'controllers/404.php';