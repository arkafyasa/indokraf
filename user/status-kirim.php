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
<title>Informasi Status Pengiriman</title>
<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="../style.css" type="text/css" />
<style>
    .input-group{
        padding-left: 3pt;
        padding-top:  3pt;
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
                <h3>Status Pengriman</h3>
            </div>
            
            <table class="table table-hover">
                <tr>
                    <th>Nama Produk</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Pembeli</th>
                    <th>Tanggal pengiriman</th>
                    <th>Status pengiriman</th>
                </tr>
                <tbody>
                    <?php 
                      /*  include "../dbconnect.php"; 
                        $sql=sqlsrv_query($conn, "SELECT * FROM produk WHERE email_penjual = '$_SESSION[user]'"); 
                        while ($data=sqlsrv_fetch_array($sql)){ 
                            echo "<tr>
                                    <td><a href='../barang/detail.php?idproduk=$data[ID_Produk]&&email=$data[email_Penjual]'>$data[nama_Produk]</a></td>
                                    <td>$data[harga]</td>
                                    <td>$data[jenis]</td>
                                    <td>$data[stok]</td>
                                </tr>";

                            }  */
                    ?>
                </tbody>
            </table>
            
            <div class="page-footer text-left">
                <p>Buku Lapak, Copyright kelompok basdat kelas O</p>
            </div>
        </div>
    </div>
    <script src="../scripts/jquery-1.11.3-jquery.min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>
</body>
</html>