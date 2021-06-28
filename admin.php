<?php
session_start();


 if(array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID'] ==3666 ) {
        
        
       
         }
 else {
        
        header("Location: logout.php");
         
    }
      
        $link=mysqli_connect("127.0.0.1:3306","root","","lmsystem2");
    $query=mysqli_query($link,("SELECT CL,EL,OD,PERMISIONS,LOP,LATECOMING from `tblemployee` WHERE EMPID = '".$_SESSION['EMPID']."' "));
    $update = mysqli_fetch_array($query);
    
?>

<!DOCTYPE html>
<html>
    
    <head profile="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg">
        <link rel="icon" 
      type="image/png" 
      href="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg">
        
        <title>Leave Management Portal</title>
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
          <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
        
        <style>
            
            .topbar {
                
                background-color: orange;
                height: 60px;
                width: 100%;
                position: fixed;
                z-index: 2;
                
            }
            
            
            #logout{
                
                float: right;
                margin: 10px 20px auto;
            }
            
            .heading{
                
                font-size: 36px;
            }
            .anits{
                
                border-radius: 10px;
                margin-left: 25px;
                margin-right: 20px;
                margin-bottom: 15px;
            }
            .nav {
                padding-top: 30px;
            }
            .dev {
                float: right;
                margin-top: 410px;
                margin-right: 10px;
            }
            
        </style>
        
    </head>
    
    <body>
        
        <div class="topbar">
            <img class="anits" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg" width="50px">
            <span class="heading" >Leave Management Portal</span>
            <button id="logout" type="button" class="btn btn-primary" onclick="location.href='logout.php'">Log out</button>
            
        </div>
        <div class="nav">
             
            <ul class="nav nav-tabs">
              <li role="presentation" class="active"><a href="admin.php">Home</a></li>
              <li role="presentation"><a href="uphdays.php">Update Holidays</a></li>
              <li role="presentation"><a href="upuser.php">Update User Details</a></li>
              <li role="presentation" class="navbar-text" style="float:right">ID : <?php echo $_SESSION['EMPID'];?></li>
              <li role="presentation" class="navbar-text" style="float:right">Name : <?php echo $_SESSION['EMPNAME'];?></li>  
            </ul>
             
         </div>
        <div class="dev">
                Developed by students of Information Technology 2018-2022.
            </div>
    </body>
</html>
