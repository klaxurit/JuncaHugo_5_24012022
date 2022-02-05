<?php
// phpinfo();
error_reporting(-1);
require '../vendor/autoload.php';

// die($_GET['url']);

// Create a new instance of Router
$router = new App\Router($_GET['url']);

$router->get('/posts', function(){ echo 'Affichage de tout les articles'; });
$router->get('/posts/:id', function($id){ echo 'Affichage de l\'article ' . $id; });
$router->post('/posts/:id', function($id){ echo 'Article ' . $id . ' poster'; });

$router->run();
