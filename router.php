<?php
require_once  'libs/';
require_once 'controllers/APIController.php';


$router = new Router();

    #Review             endpoint                          verbo                     controller            metodo
    $router->addRoute('reseñas'      ,            'GET',     'APIController',   'getAllReview');
    $router->addRoute('reseñas/:id'  ,            'GET',     'APIController',   'getReview'   );
  //  $router->addRoute('reseñas/:id'  ,            'DELETE',  'APIController',   'delete');
  //  $router->addRoute('reseñas'  ,                'POST',    'APIController',   'create');
  //  $router->addRoute('reseñas/:id'  ,            'PUT',     'APIController',   'update');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
