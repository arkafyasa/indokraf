<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

	if( $_SESSION['user'] == "" ) {
		header("Location: login.php");
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
    <title>Welcome -
        <?php echo $userRow['nama']; ?>
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <style>
        .tbody{
        overflow:auto;
        height:10px;
    }
    </style>
</head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="homepage.php"><img src="images/logo.png" alt="indokraf" style="border:0;">
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="homepage.php">Beranda</a>
                        </li>
                        <li>
                            <a href="task/top-produk10.php">10 Produk Terlaris</a>
                        </li>
                        <li>
                            <a href="task/top-toko5.php">5 Toko Paling Laris</a>
                        </li>

                    </ul>
                    <form class="navbar-form navbar-left" action="barang/cari-barang.php" method="get">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Cari Barang" name="cari">
                      </div>
                      <button type="submit" class="btn btn-default" name="">Cari</button>
                      <a href="transaksi/keranjang.php" class="btn btn-info" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Keranjang</a>
                    </form>

                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user"></span>
                                <?php echo $userRow['nama']; ?>&nbsp;<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="user/tambah-dagangan.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah dagangan</a></li>
                                <li><a href="user/list-dagangan.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Daftar dagangan</a></li>
                                <li><a href="user/status-kirim.php"><span class="glyphicon glyphicon-check"></span>&nbsp;Status Pengiriman</a></li>
                                <li><a href="user/ubah-profil.php"><span class="glyphicon glyphicon-edit"></span>&nbsp;Ubah Profil</a></li>
                                <li><a href="transaksi/riwayat-beli.php"><span class="glyphicon glyphicon-inbox"></span>&nbsp;Riwayat Pembelian</a></li>
                                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>
        </nav>
        <div id="wrapper">
            <div class="container">
                <div class="page-header text-center text-uppercase">
                    <h3>Beranda</h3>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                                <li data-target="#myCarousel" data-slide-to="3"></li>
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <img src="images/car2.jpg" alt="Chania" width="460" height="345">
                                </div>
                                <div class="item">
                                    <img src="images/car1.jpg" alt="Chania" width="460" height="345">
                                </div>

                                <div class="item">
                                    <img src="images/car2.jpg" alt="Flower" width="460" height="345">
                                </div>
                                <div class="item">
                                    <img src="images/car3.jpg" alt="Flower" width="460" height="345">
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                    <div class="panel panel-primary filterable">
                        <div class="panel-heading">
                            <h3 class="panel-title">Semua Produk</h3>
                            <div class="pull-right">
                                <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr class="filters">
                                    <th><p>Gambar</p></th>
                                    <th><input type="text" class="form-control" placeholder="Nama Produk" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Penjual" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Jenis" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Harga" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Stok" disabled></th>
                                </tr>
                            </thead>
                              <tbody>
                                
                                <?php
                                    $sql=sqlsrv_query($conn, "SELECT * FROM produk p join akun a on p.email_Penjual = a.email WHERE p.stok != 0 AND p.harga != 0"); 
                                    while ($data=sqlsrv_fetch_array($sql)){ 
                                        echo "<tr>
                                                <td><img src='$data[gambar]' alt='$data[nama]' style='width:50px;height:50px;'></td>
                                                <td><a href='barang/beli-barang.php?idproduk=$data[ID_Produk]&&email=$data[email_Penjual]'>$data[nama_Produk]</a></td>
                                                <td>$data[nama]</td>
                                                <td>$data[jenis]</td>
                                                <td>Rp. $data[harga]</td>
                                                <td>$data[stok]</td>
                                            </tr>";
                                        }  
                                ?>
                            </tbody>
                        </table>
                    </div>
                <div class="page-footer text-left">
                    <p>Indokraf, Indonesian creative marketplace by kelompok basdat kelas O</p>
                </div>
                </div>
            </div>
        </div>
        <script src="scripts/jquery-1.11.3-jquery.min.js"></script>
        <script src="scripts/bootstrap.min.js"></script>
        <script src="scripts/jquery.tablesorter.pager.js"></script>
        <script>
        $(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key 
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
        </script>
    </body>
</html>