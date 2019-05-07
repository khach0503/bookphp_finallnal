<?php
    //Huy session
    session_start();
    session_unset();
    session_destroy();

    //Chuyen den trang login
    header('Location: user_login.php');
?>