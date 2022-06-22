<?php
    declare (strict_types = 1);
    
    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if ($session->getCsrfToken() !== $_POST['csrf']) {
        die(header('Location: ../../index.php'));
    }

    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/restaurant.class.php');

    $db = getDatabaseConnection();

    
    $stmt = $db->prepare('INSERT INTO Review (RestaurantId, Score, Comment, UserId) VALUES(?,?,?,?)');
    try {
        $stmt->execute(array($_POST['restaurantId'], intval($_POST['score']),$_POST['comment'], $session->getId()));
    } catch (PDOException $e) {
        $session->addMessage('error','Impossible to add Review');
        die(header("Location: /../pages/showUserOrders.php"));
    }

    $session->addMessage('success','Review added successfully');

    
    header("Location: /../pages/showUserOrders.php");
?>