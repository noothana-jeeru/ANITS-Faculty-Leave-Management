<?php
$connect = mysqli_connect("127.0.0.1:3306", "root", "", "lmsystem2");
if(isset($_POST["EMPID"], $_POST["EMPNAME"]))
{
 $EMPID = mysqli_real_escape_string($connect, $_POST["EMPID"]);
 $EMPNAME = mysqli_real_escape_string($connect, $_POST["EMPNAME"]);
 $DEPARTMENT = mysqli_real_escape_string($connect, $_POST["DEPARTMENT"]);
 $USERNAME = mysqli_real_escape_string($connect, $_POST["USERNAME"]);
 $PASSWORDS = mysqli_real_escape_string($connect, $_POST["PASSWORDS"]);
 $CL = mysqli_real_escape_string($connect, $_POST["CL"]);
 $EL = mysqli_real_escape_string($connect, $_POST["EL"]);
 $OD = mysqli_real_escape_string($connect, $_POST["OD"]);
 $PERMISIONS = mysqli_real_escape_string($connect, $_POST["PERMISIONS"]);
 $LOP = mysqli_real_escape_string($connect, $_POST["LOP"]);
 $LATECOMING = mysqli_real_escape_string($connect, $_POST["LATECOMING"]);
 $query = "INSERT INTO tblemployee(EMPID,EMPNAME,DEPARTMENT,USERNAME,PASSWORDS,CL,EL,OD,PERMISIONS,LOP,LATECOMING) VALUES('$EMPID','$EMPNAME', '$DEPARTMENT', '$USERNAME', '$PASSWORDS', '$CL', '$EL', '$OD', '$PERMISIONS', '$LOP', '$LATECOMING')";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Inserted';
 }
}
?>