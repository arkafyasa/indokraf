<?php
    ob_start();
    session_start();
    include '../dbconnect.php';
    $produk = $_GET['produk'];
    $jumlah = $_GET['jumlah'];
    $id = $_GET['id'];
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
             die( print_r( sqlsrv_errors(), true ));
    }

    $sql2 = sqlsrv_query($conn,"UPDATE produk SET stok = stok + $jumlah WHERE ID_Produk = $produk");
    $sql = sqlsrv_query($conn,"DELETE FROM Keranjang WHERE ID_Produk = $produk AND ID_Keranjang = $id");
    if($sql) {
            sqlsrv_commit( $conn );
            header("Location: ".$_SERVER['HTTP_REFERER']);
        } else {
            sqlsrv_rollback( $conn );
            echo "delete fail";
    }
?>