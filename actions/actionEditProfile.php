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
        $stmt = $db->prepare('Update User SET phoneNumber = ? WHERE UserId = ?');
        try{
            $stmt->execute(array($_POST['phoneNumber'],$session->getId()));
        }catch(PDOException $e){
            $session->addMessage('error','Phone Number already exists');
            die(header("Location: /../pages/editProfile.php"));
        }
        $session->addMessage('success','Phone Number updated');
    }

    if($_POST['name']!=null){
        $stmt = $db->prepare('Update User SET Name = ? WHERE UserId = ?');
        $stmt->execute(array($_POST['name'],$session->getId()));
        $session->addMessage('success','User Name Updated');
    }

    if($_POST['password']!=null){
        $stmt = $db->prepare('Update User SET Password = ? WHERE UserId = ?');
        $stmt->execute(array(password_hash($_POST['password'],PASSWORD_DEFAULT),$session->getId()));
        $session->addMessage('success','User Password Updated');
    }


    if($_POST['address']!=null){
        $stmt = $db->prepare('Update User SET Address = ? WHERE UserId = ?');
        $stmt->execute(array($_POST['address'],$session->getId()));
        $session->addMessage('success','User Address Updated');;
    }

    header("Location: /../pages/editProfile.php");

?>