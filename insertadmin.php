<?php
$connect = mysqli_connect("127.0.0.1:3306", "root", "", "lmsystem2");
if(isset($_POST["EMPID"], $_POST["EMPNAME"], $_POST["REMARKS"]))
{
 $DATE = mysqli_real_escape_string($connect, $_POST["DATE"]);
 $EMPID = mysqli_real_escape_string($connect, $_POST["EMPID"]);
 $EMPNAME = mysqli_real_escape_string($connect, $_POST["EMPNAME"]);
 $REMARKS = mysqli_real_escape_string($connect, $_POST["REMARKS"]);
 $query = "INSERT INTO tbladmin(DATE, EMPID, EMPNAME, REMARKS) VALUES('$DATE', '$EMPID', '$EMPNAME', '$REMARKS')";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Inserted';
 }
 else
 {
     echo 'Enter Appropriate EMPID';
 }
}
?>