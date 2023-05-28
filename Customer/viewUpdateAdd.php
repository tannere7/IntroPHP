<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}

if (isset($_POST['addnew'])){
    include 'addCustomerNew.php';
}
if (isset($_POST['rownumber'])){
    include 'viewUpdateNew.php';
}
