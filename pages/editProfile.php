<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    if (!$session->isLoggedIn()) die(header('Location: /'));

    require_once(__DIR__ .'/../templates/common.tpl.php');
    require_once(__DIR__ .'/../templates/user.tpl.php');
    require_once(__DIR__ .'/../database/user.class.php');
    require_once(__DIR__ .'/../database/connection.db.php');

    $db = getDatabaseConnection();
    $user = User::getUserById($db, $session->getId());
    drawHeader($session);
    drawEditProfileForm($user,$session);
    drawFooter();
?>