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
    <title> INDOKRAF-10 PRODUK PALING LARIS
    </title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>
    <body>
       <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="homepage.php"><img src="../images/logo.png" alt="indokraf" style="border:0;">
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="../homepage.php">Beranda</a>
                        </li>
                        <li class="active">
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
                      <a href="transaksi/keranjang.php" class="btn btn-info" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Keranjang</a>
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
                <div class="page-header text-center text-uppercase">
                    <h3>10 PRODUK PALING LARIS</h3>
                </div>
                <table class="table table-hover">
                    <thead>
  <!--                       <th><p>Gambar</p></th> -->
                        <th><p>Nama Produk</p></th>
                        <th><p>Email Penjual</p></th>
                        <th><p>Jenis</p></th>
                        <th><p>Harga</p></th>
                        <th><p>Jumlah terjual</p></th>
                    </tr>
                    </thead>
                      <tbody>
                        <?php  
                            $sql=sqlsrv_query($conn, "select top 10 a.nama_Produk,a.email_Penjual, a.jenis, a.harga , sum(b.jumlah) as jumlahPembelian
                                    from Produk a join Pesanan b on a.ID_Produk=b.ID_Produk
                                    group by a.gambar,a.nama_Produk,a.email_Penjual, a.jenis, a.harga
                                    order by jumlahPembelian desc"); 
                            while ($data=sqlsrv_fetch_array($sql)){ 
                                echo "<tr>
                                        <!--<td><img src='../$data[gambar]' alt='$data[nama]' style='width:50px;height:50px;'></td>-->
                                        <td><a href='../barang/beli-barang.php?idproduk=$data[ID_Produk]&&email=$data[email_Penjual]'>$data[0]</a></td>
                                        <td>$data[1]</td>
                                        <td>$data[2]</td>
                                        <td>Rp. $data[3]</td>
                                        <td>$data[4]</td>
                                    </tr>";
                                }  
                        ?>
                    </tbody>
                </table>
                <div class="page-footer text-left">
                    <p>Footer Indokraf by kelompok basdat O</p>
                </div>
            </div>
        </div>
        <script src="../scripts/jquery-1.11.3-jquery.min.js"></script>
        <script src="../scripts/bootstrap.min.js"></script>
    </body>
</html>