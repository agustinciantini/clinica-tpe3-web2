<?php
require_once  './app/libs/router.php';
require_once './app/libs/request.php';
require_once './app/controllers/APIController.php';
require_once './app/controllers/user.api.controller.php';
require_once './app/middlewares/jwt.auth.middleware.php';


$router = new Router();
$router->addMiddleware(new JWTAuthMiddleware());

    #Review          endpoint     verbo   controller      metodo
    $router->addRoute('reviews', 'GET','APIController', 'getAllReviews');
    $router->addRoute('review/:id','GET', 'APIController','getReview');
    $router->addRoute('review', 'POST',    'APIController','createReview');
    $router->addRoute('review/:id','PUT','APIController','updateReview');
    $router->addRoute('review/:id','DELETE','APIController','deleteReview');
    $router->addRoute('token', 'GET','UserApiController','getToken');

    //reviews?pag=1
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);