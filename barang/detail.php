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
  $idproduk = $_GET['idproduk'];
  $email = $_GET['email'];
  /*AMBIL DATA BARANG*/
  $queryB = "SELECT * FROM produk WHERE ID_Produk= '$idproduk' ";
  $resB = sqlsrv_query($conn,$queryB);
  $produkRow= sqlsrv_fetch_array($resB);
  /*--------*/
}
?>
<!DOCTYPE html>
<html class="html" lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Detail Barang - <?php echo  $produkRow['nama_Produk']; ?>
    </title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../style.css" type="text/css" />
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
                    <h1>DETAIL PRODUK</h1>
                </div>
                <div class="container-fluid">
                  <div class="row content">
                    <div class="col-sm-3 sidenav">
                      <!-- MENGAMBIL DATA PENJUAL -->
                      <?php 
                        $query2 = "SELECT * FROM akun WHERE email= '$email' ";
                        $res2= sqlsrv_query($conn,$query2);
                        $userRow2= sqlsrv_fetch_array($res2);
                      ?>
                      <h3> Dijual Oleh : </h3>
                      <p class="text-uppercase"><strong>NAMA : </strong><?php echo $userRow2['nama']; ?></p>
                      <p class="text-uppercase"><strong>DOMISILI : </strong><?php echo $userRow2['kota']; ?></p>
                      <button data-toggle="collapse" href= "#show" class ="btn btn-info">Tampilkan Informasi Kontak</button>
                            <div id="show" class="collapse">
                                <p><strong>EMAIL : </strong></p><p class="text-lowercase"><?php echo $email; ?></p></br>
                                <p class="text-uppercase"><strong>NOMOR TELEPON : </strong></br><?php echo $userRow2['noHP']; ?></p>
                            </div>
                    </div>

                    <div class="col-sm-9">
                      <h2 class="text-uppercase"><strong><?php echo $produkRow['nama_Produk']; ?></strong></h2>
                      <!-- <img src="../<?php echo $produkRow['gambar']; ?>" alt="gambar tidak ada" style="width:30%;height:30%;"> -->
                      <p class="text-uppercase"></br><strong>Harga : </strong><?php echo $produkRow['harga']; ?> </p>
                      <p class="text-uppercase"><strong>kategori : </strong><?php echo $produkRow['jenis']; ?> </p> 
                      <p class="text-uppercase"><strong>stok : </strong><?php echo $produkRow['stok']; ?> </p>
                      <p><strong>DESKRIPSI</strong></br><?php echo $produkRow['keterangan']; ?> </p>
                    </div>
                    
                    </div>
                    <div class="page-footer text-left">
                      <p>Ini namanya footer website entahlah mau diiisi apa</p>
                    </div>
                  </div>
                </div>
        <script src="../scripts/jquery-1.11.3-jquery.min.js"></script>
        <script src="../scripts/bootstrap.min.js"></script>
    </body>
</html>