<?php
session_start();
    echo $_POST['masach'];
    echo $_SESSION['macart'];
    $ch_Info = curl_init();
    curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/BookIntocart/");
    curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_Info, CURLOPT_POST, 1);
    curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
    $data = array('book'=>$_POST['masach'],'macart'=>$_SESSION['macart']);
    curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

    $output = curl_exec($ch_Info);
    $info = curl_getinfo($ch_Info);
    curl_close($ch_Info);

    header("Location: cart.php");
?>