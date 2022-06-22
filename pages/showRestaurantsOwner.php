<?php
    
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if (!$session->isLoggedIn()){
        die(header('Location: /'));
    }
    
    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/restaurant.class.php');
    require_once(__DIR__ .'/../templates/restaurant.tpl.php');
    require_once(__DIR__ .'/../templates/common.tpl.php');


    $db = getDatabaseConnection();


    $restaurants = Restaurant::getRestaurantsUserId($db, $session->getId());

    drawHeader($session);
    drawRestaurantsOwner($restaurants);
    drawFooter();
?>