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
    /*PEMROSESAN DATA */
    if ( isset($_POST['btn-ubah']) ) {
        $name = $_POST['nama'];
        $tel = $_POST['telepon'];
        $pass = $_POST['password'];
        $number_rek = $_POST['rekening'];
        $kota = $_POST['kota'];
        $postal = $_POST['postal'];
        $alamat = $_POST['alamat'];     
        echo $number_rek;
        echo $a;
        /*TRANSAKSI SQL UPDATE*/
        if ( sqlsrv_begin_transaction( $conn ) === false ) {
             die( print_r( sqlsrv_errors(), true ));
        }

        $tsql1 = "UPDATE akun SET nama = ? WHERE email = ?";
        $tsql2 = "UPDATE akun SET noHP = ? WHERE email = ?";
        $tsql3 = "UPDATE akun SET password = ? WHERE email = ?";
        $tsql4 = "UPDATE akun SET kode_Pos = ? WHERE email = ?";
        $tsql5 = "UPDATE akun SET jalan = ? WHERE email = ?";
        $tsql6 = "UPDATE akun SET kota = ? WHERE email = ?";
        

        $param1 = array($name,$a);
        $param2 = array($tel,$a);
        $param3 = array($pass,$a);
        $param4 = array($postal,$a);
        $param5 = array($alamat,$a);
        $param6 = array($kota,$a);
        
        
        $sql1 = sqlsrv_query($conn,$tsql1,$param1);
        $sql2 = sqlsrv_query($conn,$tsql2,$param2); 
        $sql3 = sqlsrv_query($conn,$tsql3,$param3); 
        $sql4 = sqlsrv_query($conn,$tsql4,$param4); 
        $sql5 = sqlsrv_query($conn,$tsql5,$param5); 
        $sql6 = sqlsrv_query($conn,$tsql6,$param6); 
        

        if($sql1 && $sql2 && $sql3 && $sql4 && $sql5 && $sql6) {
            sqlsrv_commit( $conn );
            $errTyp = "success" ;
            $errMSG = "Data berhasil diperbarui !!";
            /*UPDATE TABEL PENJUAL*/
            $tsqlp ="SELECT no_Rekening FROM penjual WHERE email_penjual = '$a'";
            $sqlp = sqlsrv_query($conn, $tsqlp);
            if (sqlsrv_has_rows($sqlp) > 0 && isset($_POST['rekening'])) {
                $paramp = array($number_rek,$a);
                $tsqlp = "UPDATE penjual SET no_Rekening = ? WHERE email_Penjual = ?";
                $sqlp = sqlsrv_query($conn,$tsqlp,$paramp);
            }else{
                $sql = sqlsrv_query($conn,"SELECT email FROM admin");
                $data = sqlsrv_fetch_array($sql);
                $paramp = array($a,$data[0],$number_rek);
                $tsqlp = "INSERT INTO penjual(email_Penjual,email_Admin,no_Rekening) VALUES(?,?,?)";
                $sqlp = sqlsrv_query($conn,$tsqlp,$paramp);
            }
            /*AKHIR UPDATE*/
        } else {
            sqlsrv_rollback( $conn );
            $errTyp = "danger";
            $errMSG = "ERROR : Rollback perubahan";   
        }
        /*AKHIR TRANSAKSI*/
    }
?>
<!DOCTYPE html>
<html class="html" lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        Form ubah data profil
    </title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../style.css" type="text/css" />
    <style>
        .input-group {
            position: relative;
            display: table;
            border-collapse: separate;
            width: 30%;
        }
    </style>
</head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../homepage.php"><img src="../images/logo.png" alt="indokraf logo" style="border:0;">
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
                <div class="page-header text-center text-uppercase">
                    <h3>Form Ubah Profil User</h3>
                </div>
                
                <form method="post" action="" autocomplete="off">
                    <?php
                    if ( isset($errMSG) ) {
                        
                        ?>
                        <div class="form-group">
                        <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                        </div>
                        <?php
                    }
                    ?>
                    <h6>Nama</h6>
                    <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo $userRow['nama']; ?>"/>
                            </div>
                    </div>
                    <h6>Nomor yang bisa dihubungi</h6>
                    <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="telepon" class="form-control" placeholder="Nomor telepon" value="<?php echo $userRow['noHP']; ?>" />
                            </div>
                    </div>

                    <div class="form-group">
                        <button data-toggle="collapse" href= "#show" class ="btn btn-info">Ubah informasi sensitif</button>
                            <div id="show" class="collapse">
                                <h6>Password</h6>
                                <div class="form-group">
                                        <div class="input-group">
                                        <input type="password" name="password" class="form-control" placeholder="Ubah password" value=<?php echo $userRow['password']; ?>> </input>
                                        </div>
                                </div>
                                <?php 
                                    $queryP = "SELECT no_Rekening FROM penjual WHERE email_Penjual= '$a' ";
                                    $resP= sqlsrv_query($conn,$queryP);
                                    if ($resP) {
                                        $userRowP= sqlsrv_fetch_array($resP);
                                    }
                                    
                                ?>
                                <h6>Nomor Rekening (Jika ingin menjadi penjual)</h6>
                                <div class="form-group">
                                        <div class="input-group">
                                        <input type="text" name="rekening" class="form-control" placeholder="Ubah nomor rekening" value="<?php echo $userRowP['no_Rekening']; ?>"/>
                                        </div>
                                </div>
                            </div>  
                    </div>

                    <h4> Informasi Alamat </h4>

                    <h6>Kota</h6>
                    <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="kota" class="form-control" placeholder="Nama Kota" value="<?php echo $userRow['kota']; ?>"/>
                            </div>
                    </div>
                    
                    <h6>Alamat Jalan</h6>
                    <div class="form-group">
                          <textarea class="form-control" limit="50" name="alamat"><?php echo $userRow['jalan']; ?></textarea>
                    </div>
                    <h6>Kode Pos</h6>
                    <div class="form-group">
                            <div class="input-group">
                            <input type="text" name="postal" class="form-control" placeholder="Kode Pos" value="<?php echo $userRow['kode_Pos']; ?>"/>
                            </div>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="btn-ubah">Ubah Profil Anda</button>
                        <a href="<?php echo$_SERVER['HTTP_REFERER']?>" class="btn btn-danger" role="button">Batalkan</a>
                    </div>

                   
                </form>
                <div class="page-footer text-left">
                    <p>Ini namanya footer website entahlah mau diiisi apa</p>
                </div>
            </div>
        </div>
        <script src="../scripts/jquery-1.11.3-jquery.min.js"></script>
        <script src="../scripts/bootstrap.min.js"></script>
    </body>
</html>