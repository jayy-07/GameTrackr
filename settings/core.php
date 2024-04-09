<?php

session_start();

function check_login()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login/login.php');
        //echo 'not logged in';

        die();
    } else {
        //echo "logged in";
    }
}

check_login();
