<?php
    declare (strict_types = 1);
    
    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if ($session->getCsrfToken() !== $_POST['csrf']) {
        die(header('Location: ../../index.php'));
    }

    require_once(__DIR__ .'/../database/connection.db.php');

    $db = getDatabaseConnection();

    
    $stmt = $db->prepare('INSERT INTO Dishes (Name, Price, RestaurantId) VALUES (?, ?, ?)');
    try {
        $stmt->execute(array($_POST['name'],$_POST['price'],intval($_POST['restaurantId'])));
    } catch (PDOException $e) {
        $session->addMessage('error','Impossible to add dish');
        die(header("Location: /../pages/restaurantOwner.php?id=".$_POST['restaurantId']));
    }

    $session->addMessage('success','Dish added successfully');

    
    header("Location: /../pages/restaurantOwner.php?id=".$_POST['restaurantId']);
?>