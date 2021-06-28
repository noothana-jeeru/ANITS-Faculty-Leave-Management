<?php
$connect = mysqli_connect("127.0.0.1:3306", "root", "", "lmsystem2");
if(isset($_POST["DATEs"], $_POST["DESCRIPTIONs"]))
{
 $DATEs = mysqli_real_escape_string($connect, $_POST["DATEs"]);
 $DESCRIPTIONs = mysqli_real_escape_string($connect, $_POST["DESCRIPTIONs"]);
 $query = "INSERT INTO holydays(DATEs, DESCRIPTIONs) VALUES('$DATEs', '$DESCRIPTIONs')";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Inserted';
 }
}
?>