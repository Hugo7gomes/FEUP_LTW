<?php
    declare (strict_types = 1);

    require_once(__DIR__ .'/../database/session.class.php');

    $session = new Session();

    require_once(__DIR__ .'/../database/connection.db.php');
    require_once(__DIR__ .'/../database/user.class.php');
    require_once(__DIR__ .'/../templates/common.tpl.php');

    
    drawHeader($session);
    drawRegisterForm();
    drawFooter();

?>