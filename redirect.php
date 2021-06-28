<?php 
session_start();

           
     if((array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID']==3555)) {
        
      header("Location: hod.php");
}
else {
        
        header("Location: user.php");
                 
    }
    ?>