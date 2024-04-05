<?php

session_start();
//echo $_SESSION['user_id'];

function check_login()
{

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login/login_view.php');
        //echo 'not logged in';

        die();
    } else {
        //echo "logged in";
    }
}

check_login();
