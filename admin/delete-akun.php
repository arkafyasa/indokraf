<?php
    ob_start();
    session_start();
    include '../dbconnect.php';
    $data= $_GET['email'];
    $sql=sqlsrv_query($conn, "EXEC deleteAkun '$data'"); 
    if ($sql) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }else{
        die( print_r( sqlsrv_errors(), true ));
        echo "delete fail";
    }
?>