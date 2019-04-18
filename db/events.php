<?php
$observers = array(
    array(
        'eventname'   => '\core\event\user_loggedin',
        'callback'    => 'roomsupport_redirect_agents',
        'includefile' => '/local/roomsupport/lib.php'
    ),    
);

