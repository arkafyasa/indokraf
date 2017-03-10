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
                      <p class="text-uppercase"><strong>STATUS : </strong><?php echo $userRow2['status']; ?></p>
                      <p class="text-uppercase"><strong>DOMISILI : </strong><?php echo $userRow2['kota']; ?></p>
                      <button data-toggle="collapse" href= "#show" class ="btn btn-info">Tampilkan Informasi Kontak</button>
                            <div id="show" class="collapse">
                                <p><strong>EMAIL : </strong></p><p class="text-lowercase"><?php echo $email; ?></p></br>
                                <p class="text-uppercase"><strong>NOMOR TELEPON : </strong></br><?php echo $userRow2['noHP']; ?></p>
                            </div>
                    </div>

                    <div class="col-sm-9">
                      <h2 class="text-uppercase"><strong><?php echo $produkRow['nama_Produk']; ?></strong></h2>
                      <img src="../<?php echo $produkRow['gambar']; ?>" alt="gambar tidak ada" style="width:30%;height:30%;">
                      <p class="text-uppercase"></br><strong>Harga : </strong><?php echo $produkRow['harga']; ?> </p>
                      <p class="text-uppercase"><strong>kategori : </strong><?php echo $produkRow['jenis']; ?> </p> 
                      <p class="text-uppercase"><strong>stok : </strong><?php echo $produkRow['stok']; ?> </p>
                      <p><strong>DESKRIPSI</strong></br><?php echo $produkRow['keterangan']; ?> </p>
                      <form method="post" action="" autocomplete="off">
                        <h6>Jumlah</h6>
                        <div class="form-group">
                                <div class="input-group">
                                <input type="number" name="jml" class="form-control" placeholder="Jumlah"></input>
                                </div>
                        </div>
                        <button class='btn btn-danger' type='submit' name='btn-beli'>BELI SEKARANG</button>
                      </form>
                      <h4><strong>Orang yang membeli barang ini juga membeli barang ini (maksimal menampilkan 3 barang)</strong></h4>
                    <table>
                      <table class="table table-hover">
                          <thead>
                              <!-- <th><p>Gambar</p></th> -->
                              <th><p>Nama Produk</p></th>
                              <th><p>Harga</p></th>
                          </tr>
                          </thead>
                            <tbody>
                              <?php
                              /*BUAT VIEW TABLE, KEMUDIAN PILIH 3 PRODUK*/  
                                  $sql=sqlsrv_query($conn, "
                                    create view pembeliproduk as
                                    select t.email_Pembeli
                                    from pesanan t
                                    where t.ID_Produk=(select a.ID_Produk from Produk a where a.nama_Produk like '%$produkRow[nama_Produk]%')
                                    "); 
                                  $sql2=sqlsrv_query($conn,"
                                    CREATE VIEW data_produk_top3 as
                                    select distinct top 4 pesanan.ID_Produk, (count(pesanan.ID_Produk)) as jumlah_pembeli
                                    from pesanan join pembeliproduk
                                    on pesanan.email_Pembeli = pembeliproduk.email_Pembeli
                                    group by pesanan.ID_Produk
                                    order by (count(pesanan.ID_Produk)) desc
                                    ");
                                  $sql3=sqlsrv_query($conn,"select produk.nama_Produk,produk.harga from Produk join data_produk_top3
                                                      on produk.ID_Produk = data_produk_top3.ID_Produk
                                                      where Produk.nama_Produk != '$produkRow[nama_Produk]'");
                                  while ($data=sqlsrv_fetch_array($sql3)){ 
                                      echo "<tr>
                                              <td>$data[nama_Produk]</td>
                                              <td>Rp. $data[harga]</td>
                                          </tr>";
                                  }
                                  /*HAPUS VIEW TABLE*/
                                  $sql4=sqlsrv_query($conn,"DROP VIEW pembeliproduk");
                                  $sql5=sqlsrv_query($conn,"DROP VIEW data_produk_top3");
                                  /*------------*/
                              /*-------------------------------*/
                              ?>
                          </tbody>
                      </table>
                    </div>
                    
                    <?php
                        /*PEMROSESAN DATA */
                      if ( isset($_POST['btn-beli']) ) {

                          $subtotal = 0;
                          if ($produkRow['stok'] > $_POST['jml']) {
                            $jumlah = $_POST['jml'];
                            $update = $produkRow['stok'] - $_POST['jml'];
                          }else if ($produkRow['stok'] <= $_POST['jml']){
                            $jumlah = $produkRow['stok'];
                            $update = 0; 
                          }else{
                            $jumlah = 0;
                            $update = 0;
                          }
                          $subtotal = $jumlah * $produkRow['harga'];
                          $sqlk = "INSERT INTO keranjang VALUES (?,?,?,?,?)";
                          $paramk = array($idproduk,$_SESSION['user'],$email,$jumlah,$subtotal);
                          $tsqlk = sqlsrv_query($conn,$sqlk,$paramk);

                          $tsqlU = "UPDATE produk SET stok = $update WHERE ID_Produk = $produkRow[ID_Produk]";
                          $sqlU = sqlsrv_query($conn,$tsqlU);

                          if ($sqlk && $sqlU) {
                            header("Location: ../transaksi/keranjang.php");
                          }
                      }
                  ?>
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