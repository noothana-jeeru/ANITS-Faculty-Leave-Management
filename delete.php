<?php
$connect = mysqli_connect("127.0.0.1:3306", "root", "", "lmsystem2");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM holydays WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
?>