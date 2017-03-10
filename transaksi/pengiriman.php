<?php
    ob_start();
    session_start();
    require_once '../dbconnect.php';
    if( $_SESSION['user'] == "" ) {
        header("Location: ../login.php");
        exit;
    }else {
      $a = $_SESSION['user'];
      $query = "SELECT * FROM akun WHERE email= '$a' ";
      $res= sqlsrv_query($conn,$query);
      $userRow= sqlsrv_fetch_array($res);
    }
?>
<!DOCTYPE html>
<html class="html" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Keranjang Belanja</title>
<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="../style.css" type="text/css" />
<style>
    .input-group{
        padding-left: 3pt;
        padding-top:  3pt;
        width:40%;
    }
</style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://localhost/indokraf"><img src="../images/logo.png" alt="indokraf logo" style="border:0;">
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="../homepage.php">Beranda</a>
                        </li>
                        <li>
                            <a href="../task/top-produk10.php">10 Produk Terlaris</a>
                        </li>
                        <li>
                            <a href="../task/top-toko5.php">5 Toko Paling Laris</a>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-left">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Cari Barang">
                      </div>
                      <button type="submit" class="btn btn-default">Cari</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user"></span>
                                <?php echo $userRow['nama']; ?>&nbsp;<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="../user/tambah-dagangan.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah dagangan</a></li>
                                <li><a href="../user/list-dagangan.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Daftar dagangan</a></li>
                                <li><a href="../user/status-kirim.php"><span class="glyphicon glyphicon-check"></span>&nbsp;Status Pengiriman</a></li>
                                <li><a href="../user/ubah-profil.php"><span class="glyphicon glyphicon-edit"></span>&nbsp;Ubah Profil</a></li>
                                <li><a href="../transaksi/riwayat-beli.php"><span class="glyphicon glyphicon-inbox"></span>&nbsp;Riwayat Pembelian</a></li>
                                <li><a href="../logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
        </nav>
    <div id="wrapper">
        <div class="container">

            <div class="page-header text-left text-uppercase">
                <h3>Informasi Pengiriman</h3>
            </div>
            <?php
                $tsql1 = "SELECT sum(subHarga) FROM keranjang where email_Pembeli = '$a'";
                $sql1 = sqlsrv_query($conn,$tsql1);
                $rowHarga = sqlsrv_fetch_array($sql1);
            ?>
            <h4><strong>Total Harga Barang : </strong><?php echo $rowHarga[0] ?></h4>
            <form action="" method="post">
                <h4><strong>Alamat Pengiriman</h4>
                <h4>Kota</h4>
                <div class="input-group">
                    <input type="text" name="kota" class="form-control" placeholder="Kota Tujuan" />
                </div>
                <h4>Alamat</h4>
                <div class="input-group">
                    <textarea class="form-control" limit="50" name="alamat"></textarea>
                </div>
                <h4>Kode Pos</h4>
                <div class="input-group">
                    <input type="text" name="postal" class="form-control" placeholder="Kode Pos" />
                </div>
                </br>
                <button type="submit" class="btn btn-primary text-right" name="btn-bayar">PROSES KE PEMESANAN</button>
            </form>
            <?php
                if (isset($_POST['btn-bayar'])) {
                    /*TRANSAKSI PROSES PEMESANAN*/
                    if ( sqlsrv_begin_transaction( $conn ) === false ) {
                        die( print_r( sqlsrv_errors(), true ));
                    }

                    $tsql1 = "INSERT INTO pengiriman(Kota,Alamat,KodePos) VALUES (?,?,?)";
                    $param1 = array($_POST['kota'],$_POST['alamat'],$_POST['postal']);
                    $sql1 = sqlsrv_query($conn,$tsql1,$param1);
 
                    $tsql2 = "
                        INSERT INTO Pemesanan(ID_Pengiriman,email_Pembeli)
                        VALUES ((SELECT MAX(ID_Pengiriman) FROM pengiriman),'$a')";
                    $sql2 = sqlsrv_query($conn,$tsql2);
                    
                    if ($sql1 && $sql2) {
                        echo "berhasil";
                        sqlsrv_commit( $conn );
                        $sql3 = sqlsrv_query($conn,"SELECT MAX(ID_Pesanan) FROM Pemesanan WHERE email_Pembeli = '$a'");
                        $rowR = sqlsrv_fetch_array($sql3);
                        header("Location: selesai.php?id=$rowR[0]");
                    }else{
                        echo "gagal";
                        sqlsrv_rollback ( $conn );
                        die( print_r( sqlsrv_errors(), true ));
                    }
                    /*-----------------------------*/
                    
                }
            ?>
            <div class="page-footer text-left">
                <p>Buku Lapak, Copyright kelompok basdat kelas O</p>
            </div>
        </div>
    </div>
    <script src="../scripts/jquery-1.11.3-jquery.min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>
</body>
</html>