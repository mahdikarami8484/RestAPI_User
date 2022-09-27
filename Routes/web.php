<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();


$routes->add("users", new Route(constant('URL_SUBFOLDER') . '/user/{function}', array('controller' => 'Users_Controller', 'method'=>'index'), array('function')));
$routes->add("user", new Route(constant('URL_SUBFOLDER') . '/users/{id}', array('controller' => 'Users_Controller', 'method'=>'showUsers'), array('id' => '[0-9]+')));