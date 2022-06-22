<?php
    declare (strict_types = 1);
    
    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if ($session->getCsrfToken() !== $_POST['csrf']) {
        die(header('Location: ../../index.php'));
    }

    require_once(__DIR__ .'/../database/connection.db.php');

    $db = getDatabaseConnection();

    
    $stmt = $db->prepare('INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES(?,?,?,?,?,?)');
    try {
        $stmt->execute(array($session->getId(),$_POST['name'], $_POST['phoneNumber'],$_POST['email'],$_POST['address'],$_POST['category']));
    } catch (PDOException $e) {
        $session->addMessage('error','Impossible to add restaurant');
        die(header("Location: /../pages/addRestaurant.php"));
    }

    $session->addMessage('success','Restaurant added successfully');

    $session->setIsOwner();
    
    header("Location: /../pages/addRestaurant.php"); 
?>