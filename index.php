<?php

require_once 'vendor/autoload.php';


$loader = new Twig_Loader_Filesystem(__DIR__ . '/src/view');
$twig = new Twig_Environment($loader);

$router = new \App\Router\Router($twig);
$router->run();

