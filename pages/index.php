<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    require_once(__DIR__ .'/../templates/common.tpl.php');
    require_once(__DIR__ .'/../templates/restaurant.tpl.php');
    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/restaurant.class.php');


    $db = getDatabaseConnection();
    $restaurants = Restaurant::getRestaurants($db);


    drawHeader($session);
    if($session->isLoggedIn()){
        drawRestaurantsLogin($restaurants);
    }else{
        drawRestaurantsNotLogin($restaurants);
    }
    drawFooter();
?> 