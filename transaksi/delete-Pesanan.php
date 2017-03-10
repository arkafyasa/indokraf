<?php
    include '../dbconnect.php';
    $data= $_GET['idPesanan'];
    echo "EXEC deletePesanan ".$data."</br>";
    $sql=sqlsrv_query($conn, "EXEC deletePesanan ".$data); 
    if ($sql) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }else{
        die( print_r( sqlsrv_errors(), true ));
        echo "hapus fail";
    }
?>