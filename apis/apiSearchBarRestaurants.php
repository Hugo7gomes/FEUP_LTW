<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if (!$session->isLoggedIn()) die(header('Location: /'));

    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/restaurant.class.php');

    $db = getDatabaseConnection();

    switch($_GET['searchType']){
        case "RestaurantName":
            $restaurants = Restaurant::searchRestaurantsByName($db,$_GET['searchText']);
            break;
        case "DishName":
            $restaurants = Restaurant::searchRestaurantsByDishName($db,$_GET['searchText']);
            break;
        case "Score":
            $restaurants = Restaurant::searchRestaurantsByScore($db,floatval($_GET['searchText']));
            break;                        
    }

    echo json_encode($restaurants);
?>