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


    $stmt = $db->prepare('INSERT INTO Answers (RestaurantId, ReviewId, Answer) VALUES(?,?,?)');
    try {
        $stmt->execute(array($_POST['restaurantId'], $_POST['reviewId'],$_POST['answerText']));
    } catch (PDOException $e) {
        $session->addMessage('error','Impossible to add restaurant');
        die(header("Location: /../pages/restaurantOwner.php?id=".$_POST['restaurantId']));
    }

    $session->addMessage('success','Comment added successfully');

    
    die(header("Location: /../pages/restaurantOwner.php?id=".$_POST['restaurantId']));
?>