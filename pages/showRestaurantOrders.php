<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if (!$session->isLoggedIn()){
        die(header('Location: /'));
    }

    require_once(__DIR__ .'/../templates/common.tpl.php');
    require_once(__DIR__ .'/../templates/restaurant.tpl.php');
    require_once(__DIR__ .'/../database/restaurant.class.php');
    require_once(__DIR__ .'/../database/order.class.php');
    require_once(__DIR__ .'/../templates/order.tpl.php');
    require_once(__DIR__ .'/../database/connection.db.php');

    $db = getDatabaseConnection();

    if (!Restaurant::isRestaurantOwner($db,intval($_GET['RestaurantId']), $session->getId() )){
        die(header('Location: /'));
    }

    $orders = Order::getOrdersRestaurant($db, intval($_GET['RestaurantId']));

    
    drawHeader($session);
    drawOrdersRestaurant($orders);
    drawFooter();
?>