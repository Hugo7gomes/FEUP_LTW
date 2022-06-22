<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');


    $session = new Session();

    if (!$session->isLoggedIn()) die(header('Location: /'));

    require_once(__DIR__ .'/../templates/common.tpl.php');
    require_once(__DIR__ .'/../templates/restaurant.tpl.php');
    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/restaurant.class.php');

    $db = getDatabaseConnection();

    drawHeader($session);
    drawAddRestaurant();
    drawFooter();
?>