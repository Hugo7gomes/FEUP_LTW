<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if ($session->getCsrfToken() !== $_POST['csrf']) {
        die(header('Location: ../../index.php'));
    }

    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/user.class.php');
    require_once(__DIR__ .'/../database/restaurant.class.php');
    
    $db = getDatabaseConnection();
    
    $user = User::getUserEmailPassword($db, $_POST['email'], $_POST['password']);

    if($user != null){
        $session->setId($user->id);
        $restaurantsUser = Restaurant::getRestaurantsUserId($db,$user->id);
        if($restaurantsUser != null){
            $session->setIsOwner();
        }else{
            $session->setIsNotOwner();
        }
    }else{
        $session->addMessage('error','Password or email incorrect');
        die(header('Location: ../../index.php'));
    }
    

    header('Location: ../../index.php');
?>