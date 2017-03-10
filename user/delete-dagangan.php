<?php
    ob_start();
    session_start();
    include '../dbconnect.php';
    $e = $_SESSION['user'];
    $id = $_GET['idproduk'];
    $sql = sqlsrv_query($conn,"EXEC deleteProduk $id");
    if($sql) {
            header("Location: ".$_SERVER['HTTP_REFERER']);
        } else {
            echo "delete fail : ";
            die( print_r( sqlsrv_errors(), true ));
    }
?>