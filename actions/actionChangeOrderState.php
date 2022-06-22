<?php
    declare (strict_types = 1);
    
    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if ($session->getCsrfToken() !== $_POST['csrf']) {
        die(header('Location: ../../index.php'));
    }

    require_once(__DIR__ .'/../database/connection.db.php');

    $db = getDatabaseConnection();

    
    $stmt = $db->prepare('UPDATE Orders SET STATE = ? Where OrderId = ?');
    try {
        $stmt->execute(array($_POST['State'],$_POST['OrderId']));
    } catch (PDOException $e) {
        $session->addMessage('error','Impossible to update state');
        die(header("Location: /../pages/showRestaurantOrders.php?RestaurantId=" . $_POST['RestaurantId']));
    }

    $session->addMessage('success','Order state updated successfully');
    
    header("Location: /../pages/showRestaurantOrders.php?RestaurantId=" . $_POST['RestaurantId']);
?>