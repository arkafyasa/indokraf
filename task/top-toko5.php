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
    <title>INDOKRAF - 5 TOKO PALING LARIS
    </title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://localhost/indokraf"><img src="../images/logo.png" alt="bukulapak" style="border:0;">
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
                        <li class="active">
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
                                <li><a href="user/tambah-buku.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah dagangan</a></li>
                                <li><a href="user/list-buku.php"><span class="glyphicons glyphicon-list-alt"></span>&nbsp;Daftar dagangan</a></li>
                                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>
        </nav>
        <div id="wrapper">
            <div class="container">
                <div class="page-header text-center text-uppercase">
                    <h3>5 Penjual terlaris</h3>
                </div>
                  <table class="table">
                    <thead>
                        <th><p>Nama Penjual</p></th>
                        <th><p>Kota Domisili</p></th>
                        <th><p>Total Barang Terjual</p></th>
                    </tr>
                    </thead>
                      <tbody>
                        <?php  
                            $sql=sqlsrv_query($conn, "select top 5 a.email_Penjual, c.kota, sum(b.jumlah) as totalTerjual
                                                from Penjual a join Pesanan b
                                                on a.email_Penjual=b.email_Penjual
                                                join akun c on c.email=a.email_Penjual
                                                group by a.email_Penjual, c.kota"); 
                            while ($data=sqlsrv_fetch_array($sql)){ 
                                echo "<tr>
                                        <td>$data[0]</td>
                                        <td>$data[1]</td>
                                        <td>$data[2]</td>
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