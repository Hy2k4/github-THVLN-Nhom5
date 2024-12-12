<?php
session_start();
session_unset();
ob_start();
del_session();
function del_session(){
    unset($_SESSION['login_Id']);
    unset($_SESSION['login_fullname']);
    unset($_SESSION['login_username']);
    header('location: ./view_product.php');
}

?>