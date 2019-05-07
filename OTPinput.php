<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Luke Kire
 * Date: 20-Apr-19
 * Time: 8:26 PM
 */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/inputOTP/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)

$data = array('macart' => $_SESSION["macart"], 'accid' => $_SESSION["username"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
header("Location: OTP.php");
?>