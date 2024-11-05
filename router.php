<?php
require_once  './app/libs/router.php';
require_once './app/libs/request.php';
require_once './app/controllers/APIController.php';

$router = new Router();

    #Review          endpoint               verbo              controller                metodo
    $router->addRoute('reviews', 'GET','APIController', 'getAllReviews');
    $router->addRoute('review/:id','GET', 'APIController','getReview');
    $router->addRoute('review', 'POST',    'APIController','createReview');
    $router->addRoute('review/:id','PUT','APIController','updateReview');
    $router->addRoute('review/:id','DELETE','APIController','deleteReview');
    //reviews?pag=1
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);