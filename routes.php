
<?php

// return[
//     '/'=> 'controllers/home.php',
//     '/listings' => 'controllers/listings.php',
//     '/listings/create' => 'controllers/listings/create.php',
//     '404' => 'controllers/404.php'
// ];

$router->get('/', 'controllers/home.php');
$router->get('/listings', 'controllers/listings/index.php');
$router->get('/listings/create', 'controllers/listings/create.php');

?>