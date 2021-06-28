<?php 

session_start();
       
           
     if((array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID']) )
     {
        
      
}
else {
        
        header("Location: index.php");
                 
}

//if($_SERVER['REQUEST_METHOD'] == 'POST')
    
//{
    
    
//if (isset($_POST['approve']) )
    
//{
   // $link=mysqli_connect("127.0.0.1:3325","root","","lmsystem"); 
    
   // $query =  mysqli_query($link,("SELECT LEAVESTATUS FROM `tblleave` WHERE LEAVESTATUS='INPROCESS'"));
    
    //$query =  mysqli_query($link,("SELECT * FROM `tblleave` WHERE  EMPID = '".$_SESSION['ID']."' "));
   // if(isset($query))
   // {
        
         //$query = mysqli_query($link,("UPDATE `tblleave` SET LEAVESTATUS = 'APPROVED' WHERE 
           //                                                                             EMPID = '".$_POST['EMPID']."' 
             //                                                                     AND   LEAVEID= '".$_POST['LEAVEID']."' "));

       //$query = mysqli_query($link,("SELECT ");

//}
//}
//if (isset($_POST['reject']) )
    
//{
 //   $link=mysqli_connect("127.0.0.1:3325","root","","lmsystem"); 
    
 //   $query =  mysqli_query($link,("SELECT LEAVESTATUS FROM `tblleave` WHERE LEAVESTATUS='INPROCESS'"));
    
 //   if(isset($query))
 //   {
        
   //      $query = mysqli_query($link,("UPDATE `tblleave` SET LEAVESTATUS = 'REJECTED' WHERE 
   //                                                                                     EMPID ='".$_POST['EMPID']."'
    //                                                                               AND  LEAVEID= '".$_POST['LEAVEID']."' "));
//}
//}    
//}







?>


<!DOCTYPE html>
<html>
    
    <head profile="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg">
        <link rel="icon" 
      type="image/png" 
      href="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg">
        <title>Leave Management Portal</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
        <style>
            
            .topbar {
                
                background-color: orange;
                height: 60px;
                width: 100%;
                position: fixed;
                z-index: 2;
                
            }
            
            .sidebar {
                
                height: 100%;
                width: 15%;
                left: 0;
                background-color: #f0efed;
                padding-top: 8%;
                float: left;
                position: fixed;
                z-index: 1;
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
            .profile {
                
                margin-left: 20px;
            }
            .counters{
                
                display: table;
                margin: 0 auto;
                width: 400px;
                background-color: #f5f0e6;
                border-radius: 15px;
            }
            .counterstable{
                margin-top: 5px;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 5px;
            }
            .touchme{
                
                text-align: center;
            }
            .content {
                
                margin-left: 16%;
                margin-right: 1%;
                padding-top: 65px;
                
            }
            
            
            
            
        </style>
        
    </head>
    
    <body>
        
      <div class="topbar">
            <img class="anits" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg" width="50px">
            <span class="heading" >Leave Management Portal</span>
            <button id="logout" type="button" class="btn btn-dark" onclick="location.href='logout.php'" >Log out</button>
            
        </div>
        <div class="sidebar">
            <div class="profile">
                <p class="id">ID : <?php echo $_SESSION['EMPID'];?></p>
                <p class="name">Name : <?php echo $_SESSION['EMPNAME'];?></p>
                <p class="department">Department : IT</p>
            </div>
            <form method='post'>
            <div id="actions" class="list-group">
                  <button type="button" class="list-group-item list-group-item-action" onclick="location.href='redirect.php'">Home</button>
                   <input type="hidden" name="apply_leav" value="1">
                  <button type="button" class="list-group-item list-group-item-action" onclick="location.href='apleave.php'"> Apply Leave</button>
                  <button type="button" class="list-group-item active list-group-item-action" onclick="location.href='leavestatus.php'">My Leaves status</button>
                  
                  <button type="button" class="list-group-item list-group-item-action"onclick="location.href='holidayslist.php'">Holidays List</button>
                  
            </div>
              </form >
        </div>
        
        <div class="content">
            
             <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Leave Status</li>
              </ol>
            </nav>
            
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link" href="leavestatus.php">In-process</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="leavestatus_1.php">Approved/Rejeceted</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="leavestatus_2.php">Edit Last leave</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="leavestatus_3.php">Admin Remarks</a>
              </li>
            </ul>
            
            <div class="appliedleaaves">
                
                <?php
                    
                   $link=mysqli_connect("127.0.0.1:3306","root","","lmsystem2");  
    
     $query =  mysqli_query($link,("SELECT * FROM `tbladmin` WHERE  EMPID = '".$_SESSION['EMPID']."' ORDER BY id DESC "));
    if(isset($query))
    {
  if($query->num_rows >= 1){

    echo '<div class="card mb-md-5">
    
        <table class="table table-bordered table-responsive-sm table-sm w-100">

            <thead class="thead-light">
                <th>DATE</th>
                <th>EMPID</th>
                <th>EMPNAME</th>
                <th>REMARKS</th>
                </thead>';

    while ($row = $query->fetch_object()){
    
        
        $student = <<<STAFF
                <tr>
        
                    <td>$row->DATE</td>
                    <td>$row->EMPID</td>
                    <td>$row->EMPNAME</td>
                    <td>$row->REMARKS</td>
                    

                </tr>  
                                
STAFF;

    echo $student; 
    }
    
    echo '</table></div>';
}else
  {
    echo '<div class="mt-4">
        <h1 class="text-md text-center">No remarks from Admin are available</h1></div>';
}
} 
                    
                ?>
                
            </div>
            
        </div>
        
        
        
    </body>
</html>

