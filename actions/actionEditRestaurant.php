<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if (!$session->isLoggedIn()) die(header('Location: /'));


    if ($session->getCsrfToken() !== $_POST['csrf']) {
        die(header('Location: ../../index.php'));
    }

    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/user.class.php');
    
    $db = getDatabaseConnection();



    if($_POST['phoneNumber']!=null){
        $stmt = $db->prepare('Update Restaurant SET phoneNumber = ? WHERE RestaurantId = ?');
        try{
            $stmt->execute(array($_POST['phoneNumber'],$_GET['RestaurantId']));
        }catch(PDOException $e){
            $session->addMessage('error','Phone Number already exists');
            die(header("Location: /../pages/editRestaurant.php?RestaurantId=".$_GET['RestaurantId']));
        }
        $session->addMessage('success','Phone Number updated');
    }

    if($_POST['name']!=null){
        $stmt = $db->prepare('Update Restaurant SET Name = ? WHERE RestaurantId = ?');
        try{
            $stmt->execute(array($_POST['name'],$_GET['RestaurantId']));
        }catch(PDOException $e){
            $session->addMessage('error','Restaurant Name already exists');
            die(header("Location: /../pages/editRestaurant.php?RestaurantId=".$_GET['RestaurantId']));
        }            
        $session->addMessage('success','User Name Updated');
    }


    if($_POST['address']!=null){
        $stmt = $db->prepare('Update Restaurant SET Address = ? WHERE RestaurantId = ?');
        $stmt->execute(array($_POST['address'],$_GET['RestaurantId']));
        $session->addMessage('success','User Address Updated');;
    }

    if($_POST['category']!=null){
        $stmt = $db->prepare('Update Restaurant SET CategoryName = ? WHERE RestaurantId = ?');
        $stmt->execute(array($_POST['category'],$_GET['RestaurantId']));
        $session->addMessage('success','Restaurant Category Updated');
    }

    header("Location: /../pages/editRestaurant.php?RestaurantId=".$_GET['RestaurantId']);

?>