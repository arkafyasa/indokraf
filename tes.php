


<html>
<head>
<title>UPLOAD GAMBAR</title>
</head>
<body>
<form enctype="multipart/form-data" action="" method="post" name="changer">
<input name="image" accept="image/jpeg" type="file">
<input value="Submit" type="submit">
</form>
<?php

  include 'dbconnect.php';

  if ($_FILES["image"]["error"] > 0)
  {
     echo "<font size = '5'><font color=\"#e31919\">Error: NO CHOSEN FILE <br />";
     echo"<p><font size = '5'><font color=\"#e31919\">INSERT TO DATABASE FAILED";
   }
   else
   {
     move_uploaded_file($_FILES["image"]["tmp_name"],"images/" . $_FILES["image"]["name"]);
     echo"<font size = '5'><font color=\"#0CF44A\">SAVED<br>";
     $file="images/".$_FILES["image"]["name"];
     $sql="INSERT INTO eikones (auxon, path) VALUES ('','$file')";
     if (!sqlsrv_query($conn,$sql))
     {
        die('Error: ' . mysql_error());
     }
     echo "<font size = '5'><font color=\"#0CF44A\">SAVED TO DATABASE";

   }
   mysql_close();
?>
</body>
</html>