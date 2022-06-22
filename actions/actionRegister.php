<?php
    declare (strict_types = 1);
    
    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if ($session->getCsrfToken() !== $_POST['csrf']) {
        die(header('Location: ../../index.php'));
    }

    require_once(__DIR__ .'/../database/connection.db.php');

    $db = getDatabaseConnection();


    $address = null;
    $phoneNumber = null;
    
    
    $stmt = $db->prepare('INSERT INTO User (Password, Name, Email,Address,PhoneNumber) VALUES (?, ?, ?,?,?)');
    try {
        $stmt->execute(array(password_hash($_POST['password'],PASSWORD_DEFAULT),$_POST['name'], $_POST['email'],$address,$phoneNumber));
    } catch (PDOException $e) {
        $session->addMessage('error','Email already exists');
        die(header('Location: /../pages/register.php'));
    }
    
    $stmt1 = $db->prepare('SELECT UserId FROM USER WHERE Email = ?');
    $email = strval($_POST['email']);
    $stmt1->execute(array($email));

    if($user = $stmt1->fetch()){
       $session->setId(intval($user['UserId']));
    }
    header('Location: ../../index.php'); 
?>