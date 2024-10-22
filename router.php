<?php
require_once  'libs/';
require_once 'controllers/APIController.php';


$router = new Router();

    #                  endpoint                   verbo       controller         metodo
    $router->addRoute('reseñas'      ,            'GET',     'APIController',   'getAll');
    $router->addRoute('reseñas/:id'  ,            'GET',     'APIController',   'get'   );
    $router->addRoute('reseñas/:id'  ,            'DELETE',  'APIController',   'delete');
    $router->addRoute('reseñas'  ,                'POST',    'APIController',   'create');
    $router->addRoute('reseñas/:id'  ,            'PUT',     'APIController',   'update');
    $router->addRoute('reseñas/:id/finalizada'  , 'PUT',     'APIController',   'setFinalize');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
