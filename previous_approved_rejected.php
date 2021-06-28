<?php 

session_start();
       
           
     if((array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID']==3555) )
     {
        
      
}
else {
        
        header("Location: index.php");
                 
}
error_reporting(0);









/*if($_SERVER['REQUEST_METHOD'] == 'POST')
    
{
    
    
if (isset($_POST['approve']) )
    
{
    $link=mysqli_connect("127.0.0.1:3325","root","","lmsystem"); 
    
    $query =  mysqli_query($link,("SELECT LEAVESTATUS FROM `tblleave` WHERE LEAVESTATUS='INPROCESS'"));
    
    
    if(isset($query))
    {
        
         $query = mysqli_query($link,("UPDATE `tblleave` SET LEAVESTATUS = 'APPROVED' WHERE 
                                                                                        EMPID = '".$_POST['EMPID']."' 
                                                                                  AND   LEAVEID= '".$_POST['LEAVEID']."' "));

    

}
}
if (isset($_POST['reject']) )
    
{
    $link=mysqli_connect("127.0.0.1:3325","root","","lmsystem"); 
    
    $query =  mysqli_query($link,("SELECT LEAVESTATUS FROM `tblleave` WHERE LEAVESTATUS='INPROCESS'"));
    
    if(isset($query))
    {
        
         $query = mysqli_query($link,("UPDATE `tblleave` SET LEAVESTATUS = 'REJECTED' WHERE 
                                                                                        EMPID ='".$_POST['EMPID']."'
                                                                                   AND  LEAVEID= '".$_POST['LEAVEID']."' "));

    

}
}    
}
*/

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
                  <button type="button" class="list-group-item list-group-item-action" onclick="location.href='leavestatus.php'">My Leaves status</button>
                  
                  <button type="button" class="list-group-item list-group-item-action"onclick="location.href='holidayslist.php'">Holidays List</button>
                  <button type="button" class="list-group-item active list-group-item-action" onclick="location.href='previous_approved_rejected.php'">Previous Actions</button>
                  <button style="margin-top:10px" type="button" class="btn btn-warning"onclick="location.href='approve_reject.php'">Approve/Reject Requests</button>
            </div>
              </form >
        </div>
        
        <div class="content">
            
             <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Previous Requests</li>
              </ol>
            </nav>
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="previous_approved_rejected.php">Undergoing Leaves</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="previous_approved_rejected_1.php">Completed Leaves</a>
              </li>
            </ul>
            
            <div class="appliedleaaves">
                
                <?php
                    
                    if (isset($_POST['reject']) )
    
{
      
        $link=mysqli_connect("127.0.0.1:3306","root","","lmsystem2");
    
    $query =  mysqli_query($link,("SELECT LEAVESTATUS FROM `tblleave` WHERE LEAVESTATUS='APPROVED'"));
    
    if(isset($query))
    {
        
          
$query =  mysqli_query($link,("SELECT CL_USED,EL_USED,OD_USED,PERMISIONS__USED,LOP__USED,LATECOMING__USED,HALFCL__USED,HALFOD__USED,EXTRAPER__USED  FROM `tblleave` WHERE LEAVESTATUS='APPROVED'AND EMPID = '".$_POST['EMPID']."' 
                                  AND   LEAVEID= '".$_POST['LEAVEID']."' "));
$row2 = mysqli_fetch_array($query);

$leave=mysqli_query($link,("SELECT CL,EL,OD,PERMISIONS,LOP,LATECOMING,PERMISIONFLAG from `tblemployee` WHERE 
EMPID = '".$_POST['EMPID']."' "));
$row1 = mysqli_fetch_array($leave);

$row1['CL']=$row1['CL']+$row2['CL_USED'];
$RC1=$row1['CL'];
$row1['EL']=$row1['EL']+$row2['EL_USED'];
$RC2=$row1['EL'];
$row1['OD']=$row1['OD']+$row2['OD_USED'];
$RC3=$row1['OD'];
$row1['PERMISIONS']=$row1['PERMISIONS']+$row2['PERMISIONS__USED'];
$RC4=$row1['PERMISIONS'];
$row1['LOP']=$row1['LOP']-$row2['LOP__USED'];
$RC5=$row1['LOP'];
$row1['CL']=$row1['CL']+$row2['HALFCL__USED'];
$RC6=$row1['CL'];
$row1['OD']=$row1['OD']+$row2['HALFOD__USED'];
$RC7=$row1['OD'];
$row1['CL']=$row1['CL']+$row2['EXTRAPER__USED'];
        $RC8=$row1['CL'];
mysqli_query($link,("UPDATE `tblemployee` SET  CL='{$RC1}',EL='{$RC2}',OD='{$RC3}',PERMISIONS='{$RC4}',LOP='{$RC5}',CL='{$RC6}',OD='{$RC7}',CL='{$RC8}'WHERE 
                                                                                        EMPID = '".$_POST['EMPID']."' "));
 if($row2['CL_USED']==0 AND $row2['EL_USED']==0  AND $row2['OD_USED']==0  AND $row2['PERMISIONS__USED']==0 AND $row2['LOP__USED']==0 AND $row2['HALFOD__USED']==0 AND $row2['HALFCL__USED'] AND $row2['LATECOMING__USED'] ==0 OR $row2['LOP__USED']!=0 AND $row2['EXTRAPER__USED']!=0 )
 {
if($row1['PERMISIONFLAG']==0)
{


$R1=1;
    //echo( $R1);
    mysqli_query($link,("UPDATE `tblemployee` SET PERMISIONFLAG='{$R1}' WHERE 
                                                                                       EMPID = '".$_POST['EMPID']."' "));


}
else if($row1['PERMISIONFLAG']==1)
{



$R1=0;
    //echo( $R1);
    mysqli_query($link,("UPDATE `tblemployee` SET PERMISIONFLAG='{$R1}' WHERE 
                                                                                        EMPID = '".$_POST['EMPID']."' "));
}



}
mysqli_query($link,("UPDATE `tblleave` SET LEAVESTATUS = 'REJECTED' WHERE 
                                                                                        EMPID ='".$_POST['EMPID']."'
                                                                                   AND  LEAVEID= '".$_POST['LEAVEID']."' "));


}
}    


  
    $link=mysqli_connect("127.0.0.1:3306","root","","lmsystem2"); 
    $query =  mysqli_query($link,("SELECT * FROM `tblleave` WHERE (LEAVESTATUS  != 'INPROCESS' AND LEAVESTATUS  != 'EDITED_REQUEST') AND (DATEEND >= CURDATE()) ORDER BY LEAVEID DESC"));

  if($query->num_rows > 0){

    echo '<div class="card mb-md-5">
        <table class="table table-bordered table-responsive-sm table-sm w-100">

            <thead class="thead-light">
                <th>EMPNAME</th>
                <th>STARTDATE</th>
                <th>ENDDATE</th>
                <th>DAYS</th>
                <th>TYPEOFLEAVE</th>
                <th>TIME</th>
                <th>SHIFT</th>
                <th>REASON</th>
                <th>ADJUSTMENTS</th>
                <th>LEAVESTATUS</th>
                <th>DATEPOSTED</th>
                <th>HOD_REMARKS</th>
                <th>ACTION</th>
            </thead>';

    while ($row = $query->fetch_object()){
    
        
        $student = <<<STAFF
                <tr>
        
                    <td>$row->EMPNAME</td>
                    <td>$row->DATESTART</td>
                    <td>$row->DATEEND</td>
                    <td>$row->NOOFDAYS</td>
                    <td>$row->TYPEOFLEAVE</td>
                    <td>$row->TIME</td>
                    <td>$row->SHIFT</td>
                    <td>$row->REASON</td>
                    <td>$row->ADJUSTMENT</td>
                    <td>$row->LEAVESTATUS</td>
                    <td>$row->DATEPOSTED</td>
                    <td>$row->ADMINREMARKS</td>
                    
                    <td><form  method="post" >
                    <input type="hidden" name="EMPID" value="$row->EMPID" >
                    <input type="hidden" name="LEAVEID" value="$row->LEAVEID">
                    <button type="submit" id="reject " name="reject" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure,to reject leave request')">Reject</button>
                   </form>
               </td>
                </tr>

                
         
                   
STAFF;

    echo $student; 
    }
    
    echo '</table></div>';
}else
  {
    echo '<div class="mt-4">
        <h1 class="text-md text-center">No Previous Requests Available</h1></div>';
}

                    
                ?>
                
            </div>
            
        </div>

<!--<form action='/' method='POST' onsubmit='disableButton()'>
    <input name='txt' type='text' required />
    <button id='btn' type='submit'>Post</button>
</form>-->


    </body>
</html>

