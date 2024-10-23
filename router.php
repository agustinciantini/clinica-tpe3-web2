<?php
require_once  './app/libs/router.php';
require_once './app/libs/request.php';
require_once './app/controllers/APIController.php';



$router = new Router();

    #Review          endpoint                          verbo                     controller            metodo
    $router->addRoute('review'      ,            'GET',     'APIController',   'getAll');
    $router->addRoute('review/:id'  ,            'GET',     'APIController',   'getReview'   );
    $router->addRoute('review/:id'  ,            'DELETE',  'APIController',   'delete');
    $router->addRoute('review/:id'  ,            'PUT',     'APIController',   'update');
    //  $router->addRoute('reseñas'  ,                'POST',    'APIController',   'create');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
