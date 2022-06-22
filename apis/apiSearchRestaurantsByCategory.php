<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if (!$session->isLoggedIn()) die(header('Location: /'));

    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/restaurant.class.php');

    $db = getDatabaseConnection();
    
    if($_GET['category'] === 'Favorites'){
        $restaurants = Restaurant::searchRestaurantsFavorites($db,$session->getId());
    }else{
        $restaurants = Restaurant::searchRestaurantsByCategory($db,$_GET['category']);
    }


    echo json_encode($restaurants);
?>