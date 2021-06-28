<?php 
session_start();
error_reporting(0);
$message="All fields are mandatory !";

           
     if((array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID']) ) {
        
      
}
else {
        
        header("Location: index.php");
                 
    }
  
$link=mysqli_connect("127.0.0.1:3306","root","","lmsystem2");
$query=mysqli_query($link,("SELECT CL,EL,OD,PERMISIONS,LOP,LATECOMING from `tblemployee` WHERE EMPID = '".$_SESSION['EMPID']."' "));
$update = mysqli_fetch_array($query); 
        
        
if($_SERVER['REQUEST_METHOD'] == 'POST')
 {
   
      $mindate = $_POST['datepicker']; 
      $mindate=  date("Y-m-d", strtotime( $mindate ));

      $maxdate = $_POST['date'];
      $maxdate=  date("Y-m-d", strtotime( $maxdate ));
  }
  /*this is a function which returns dates b/w two dates */
function createDateRange($startDate, $endDate, $format = "Y-m-d")
{
    $begin = new DateTime($startDate);
    $end = new DateTime($endDate);
 
    $interval = new DateInterval('P1D'); 
    $dateRange = new DatePeriod($begin, $interval, $end);
 
    $range = [];
    
    for($i=$begin;$i<=$end;$i->modify('+1 day')) {
        $range[] = $i->format($format);
        
    }
    return $range;   
}


if (isset($_POST['submit']) AND isset($_POST['radio'] )AND isset($_POST['Reason']) AND isset($_POST['adjustment']) AND isset($_POST['datepicker']) AND isset($_POST['date']) )
{
/* to bring holydayslist form db */
                    $link=mysqli_connect("127.0.0.1:3306","root","","lmsystem2");
                    $q =  mysqli_query($link,("SELECT * FROM `tblleave` WHERE LEAVESTATUS='INPROCESS'AND EMPID = '".$_SESSION['EMPID']."' 
                                   "));
                                   $u = mysqli_fetch_array($q); 
                    if(isset($u))
                    {
                      $message="";
                      $message .="Already one leave request is INPROCESS. ";
                      $message .="Leave not Submitted.";
                    }
                    else{
                    //$reason = $mysqli_real_escape_string($_POST['Reason']);
 /* after applying leave date is send to data base */                
  
    
 
                    $query = "SELECT  DATEs  FROM `holydays`";
                    $holydays = [];
                    $result = mysqli_query($link,$query);
                
                    while($holyday = mysqli_fetch_array($result))
                     $holydays [] = $holyday['DATEs'];
                     //print_r($holydays);

if(($_POST['radio'] == 'radio-1'))
{
 /* this is the session elements which comes from db noOf cl's*/
 $cl= $update['CL'];
/* to find rang of b/w two dates and calculating working days LEAVES in range (by  removing nofoholidays from the range) */
  $alldates=createDateRange($mindate, $maxdate);

  $count = count($alldates);

  $h=array_intersect($alldates,$holydays);
 
   $hcount = count($h);

   $workingdays=$count-$hcount;

 /*cl's can be use maxmum 4 at a time but if you dont have minimum 4 cl's in database you can only use how many you have in db */  
 
 if($cl>4)

 {


  $max=4;

 }
else{

	$max=$cl;
}

  $clmax=$max;
 

  if($workingdays<= $clmax AND $workingdays!=0 AND $workingdays<=4 )
  {


    

     $applied=$count-$hcount;
     
     $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,CL_USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Casual Leave')  ");
    
        $message="";
        $message .="$applied CLs Used. ";
        $message .="Leave Submitted.";
    
    
    //header("Location:redirect.php");
  }
  

 else if($workingdays>$clmax AND $count != 0 )
  {
     
     
    $lop=$workingdays-$clmax;
    //print_r($lop);
   $noofdays=$lop+$clmax;
     $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,CL_USED,LOP__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$clmax,$lop,$noofdays,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay')  ");

     $message="";
     $message .="You have only $clmax CLs, so you have used $lop LOPs. ";
     $message .="Leave Submitted.";
    
  } 
 else if($count != 0 AND $workingdays==0)
  {
    
        $message="";
        $message .="All selected dates are Public Holidays. ";
        $message .="Leave Not Submitted.";
     //echo $workingdays;
     
  } 
  
   else
  {
    $message="";
    $message .="You have selected dates in inappropriate order. ";
    $message .="Leave not Submitted.";
  } 
  
 }





else if(($_POST['radio'] == 'radio-2'))
 {
 /* this is the session elements which comes from db noOf el's*/
  $elmax=$update['EL'];
/* to find rang of b/w two dates and nofo days in that range */
   $alldates=createDateRange($mindate, $maxdate);

   $count = count($alldates);
  
  if($count<=$elmax AND $count != 0)
  {
    
/* to bring enddate of your previous form db */

  $query = "SELECT *
                   FROM  tblleave 
                    WHERE EMPID ='".$_SESSION['EMPID']."' AND LEAVESTATUS='APPROVED' ORDER BY LEAVEID DESC LIMIT 1";
                   if($result = mysqli_query($link, $query))
                   { 
                     
                
                    $row = mysqli_fetch_array($result);

                  
                
                    if (isset($row)) {
                     
                          $lastdate = $row['DATEEND'];
                          
                  
                       
                       

                    }

                   }
 /* to find range of days between  enddate of your previous and  startday of your present leave */                  
    $dates1=createDateRange($lastdate,$mindate);
    //print_r($lastdate);
    $dates  = $dates1;
    
    array_pop($dates);
    unset($dates[0]);
   //print_r($dates);
    $countofdates = count($dates);
    
    $holydaydates = array_intersect($dates,$holydays);

    $countofholydaydates = count($holydaydates);
    $applied=$count;
/* if all the days between enddate of your previous and  startday of your present leave are publicholydays or collegeholydays  all those days will be added as your used el's */ 
     if ($countofdates == $countofholydaydates)
    {
       $applied=$countofdates+$count;
      $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,EL_USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Earned Leave')  ");
    
     
     $message="";
     $message .="$applied ELs used. ";
     $message .="Leave Submitted.";
      
    }
    
   else 
   {
       
      $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,EL_USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Earned Leave')  ");;

     $message="";
     $message .="$count ELs used. ";
     $message .="Leave Submitted.";
   }

  
  }
   else if($count>$elmax AND $count != 0)
  {
    

    $lop=$count-$elmax;
    //print_r($lop);
   $noofdays=$lop+$elmax;
     $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,EL_USED,LOP__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$elmax,$lop,$noofdays,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay')  ");
 
    $message="";
    $message .="You have only $elmax ELs, so you have used $lop LOPs. ";
    $message .="Leave Submitted.";

  }  
  else
  {
    $message="";
    $message .="You have selected dates in inappropriate order. ";
    $message .="Leave not Submitted.";
  }

 }




else if(($_POST['radio'] == 'radio-3'))
 {
 $odmax= $update['OD'];

   $alldates=createDateRange($mindate, $maxdate);

  $count = count($alldates);

  $h=array_intersect($alldates,$holydays);
 
   $hcount = count($h); 

   $workingdays=$count-$hcount;
  
  if($workingdays<=$odmax AND $count != 0 AND $workingdays<=10)
  {

    
    $applied=$count-$hcount;

   $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,OD_USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','On Duty')  ");
    $message="";
    $message .="$applied ODs used. ";
    $message .="Leave Submitted.";
    
  }
  else if($count>$odmax AND $count != 0 AND $workingdays==0)
  {
    
     $message="";
     $message .="All selected dates are Public Holidays. ";
     $message .="Leave Not Submitted.";
   
     
  } 

 else if($count>$odmax AND $count != 0 )
  {
     
     $message="";
     $message .="You are having only $odmax ODs, you cannot use more than $odmax ODs. ";
     $message .="Leave Not Submitted.";
   
     
  } 
   else
  {
    $message="";
    $message .="You have selected dates in inappropriate order. ";
    $message .="Leave not Submitted.";
  } 

 }




 else if($_POST['radio'] == 'radio-5' AND $_POST['shift'])
  {

  $updatehcl=$update['CL']+$update['CL'];

  $halfclmax=$updatehcl;

   $alldates=createDateRange($mindate, $maxdate);

   $count = count($alldates);
  
  if($count<=$halfclmax AND $count != 0 AND $count<=1)
  {
    
    
 
   $applie=0.5;
   $applied=floatval($applie);

    $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,HALFCL__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE,SHIFT) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$applied,$applie,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Casual Leave','".mysqli_real_escape_string($link, $_POST['shift'])."')  ");
    $message="";
    $message .="$applied CL used. ";
    $message .="Leave Submitted.";

  }
    else if($count>1 AND $count != 0)
  {
    $message="";
    $message .="You can't use more than 1 Half CL. ";
    $message .="Leave not Submitted.";
  
    
  } 

   else if($count==1 AND $count != 0)
  {
    

    $lop=0.5;
   
     $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,LOP__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE,SHIFT) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$lop,$lop,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay','".mysqli_real_escape_string($link, $_POST['shift'])."')");
    $message="";
    $message .="0.5 LOPs used. ";
    $message .="Leave Submitted.";
  } 

   else
  {
    $message="";
    $message .="You have selected dates in inappropriate order. ";
    $message .="Leave not Submitted.";
    //print_r($count);
  } 
 }

else if(($_POST['radio'] == 'radio-6') AND $_POST['shift'])
  {

  $updatehcl=$update['OD']+$update['OD'];

  $halfodmax=$updatehcl;

   $alldates=createDateRange($mindate, $maxdate);

   $count = count($alldates);
  
  
  if($count<=$halfodmax AND $count != 0 AND $count<=1)
  {

    //echo "submitted";
    
   $applie=0.5;
   $applied=floatval($applie);

     $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,HALFOD__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE,SHIFT) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','On Duty','".mysqli_real_escape_string($link, $_POST['shift'])."')  ");
    $message="";
    $message .="$applied OD used. ";
    $message .="Leave Submitted.";
    
    
  }
    else if($count>1 AND $count != 0)
  {
    $message="";
    $message .="You can't use more than 1 Half CL. ";
    $message .="Leave not Submitted.";
  
    
  } 
   else if($count==1 AND $count != 0)
  {
    
    $lop=0.5;
    //print_r($lop);
   
     $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,LOP__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE,SHIFT) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','EDITED_REQUEST',CURDATE(),$lop,$lop,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay','".mysqli_real_escape_string($link, $_POST['shift'])."')  ");
    $message="";
    $message .="0.5 LOPs used. ";
    $message .="Leave Submitted.";
  
    
  } 

   else
  {
    $message="";
    $message .="You have selected dates in inappropriate order. ";
    $message .="Leave not Submitted.";
    //print_r($count);
  } 
 }

}
}


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
        
          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
          <link rel="stylesheet" href="/resources/demos/style.css">
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
        <script>
        $(document).ready(function(){
            $('input[type="radio"]').click(function(){
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".extra").not(targetBox).hide();
                $(targetBox).show();
            });
        });
        </script>
        <script>
            
            $( function() {
                $( "#datepicker" ).datepicker({ minDate: -20, maxDate: "+1M +10D" });
              } );
            
            $( function() {
                $( "#date" ).datepicker({ minDate: -20, maxDate: "+1M +10D" });
              } );
            
            $( function() {
                $( "#datepicker" ).datepicker();
              } );
              
            $( function() {
                $( "#date" ).datepicker();
              } );
            
            $( function() {
                $( "input" ).checkboxradio();
                $( "fieldset" ).controlgroup();
              } );
            
            
              </script>
        
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
            .leave{
                
                display: table;
                background-color:#f0efed;
                padding: 25px;
                border-radius: 10px;
                width: 800px;
                margin-left: 31%;
                text-align: center;
                border: 1px solid lightgrey;
                
                
            }
            .subheads {
                
                font-size: 20px;
                
            }
            
            .dtpicker {
                
                margin-top: 10px;
                
            }
            
            .datebox {
                
                border-radius: 10px;
                border: 1px solid grey;
            }
            
            .leavetype {
                
                margin-top: 10px;
                margin-bottom: 10px;
                
            }
            .reason {
                
                border-radius: 5px;
                margin-bottom: 10px;
                margin-top: 20px;
            }
            .extra {
                display: none;
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
                <a class="nav-link active" href="leavestatus_2.php">Edit Last leave</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="leavestatus_3.php">Admin Remarks</a>
              </li>
            </ul>
            
            <div class="appliedleaaves">
                
                <?php
                    
                   $link=mysqli_connect("127.0.0.1:3325","root","","lmsystem2");  
    
     $query =  mysqli_query($link,("SELECT * FROM `tblleave` WHERE  (EMPID = '".$_SESSION['EMPID']."' AND LEAVESTATUS='APPROVED') AND (TYPEOFLEAVE != 'Permission' AND TYPEOFLEAVE != 'Extra Permission') ORDER BY LEAVEID DESC LIMIT 1"));
    if(isset($query))
    {
  if($query->num_rows >= 1){

    echo '<div class="card mb-md-5">
    
        <table class="table table-bordered table-responsive-sm table-sm w-100">

            <thead class="thead-light">
                <th>EMPNAME</th>
                <th>STARTDATE</th>
                <th>ENDDATE</th>
                <th>DAYS</th>
                <th>TYPEOFLEAVE</th>
                <th>SHIFT</th>
                <th>REASON</th>
                <th>ADJUSTMENTS</th>
                <th>LEAVESTATUS</th>
                <th>HOD_REMARKS</th>
                <th>DATEPOSTED</th>
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
                    <td>$row->SHIFT</td>
                    <td>$row->REASON</td>
                    <td>$row->ADJUSTMENT</td>
                    <td>$row->LEAVESTATUS</td>
                    <td>$row->ADMINREMARKS</td>
                    <td>$row->DATEPOSTED</td>
                    <td><form  method="post" >
                    <input type="hidden" name="EMPID" value="$row->EMPID" >
                    <input type="hidden" name="LEAVEID" value="$row->LEAVEID">
                    <button type="button" class="btn btn-info btn-sm" onclick="location.href='editleave.php'">Edit</button>
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
        <h1 class="text-md text-center">No editable requests are available</h1></div>';
}
} 
                    
                ?>
                
            </div>
            
        </div>
        
        <div class="leave">
        <form method="post" autocomplete="off" >
            <div class="alert alert-success" role="alert"><?php echo $message ?></div>
            <span class="subheads">Select type of leave</span>
            <div class="leavetype">
              <fieldset>
                <input type="radio" name="radio" id="radio-1" value='radio-1' required>
                <label for="radio-1">CL</label>
                <input type="radio" name="radio" id="radio-2" value='radio-2' required>
                <label for="radio-2">EL</label>
                <input type="radio" name="radio" id="radio-3" value='radio-3' required>
                <label for="radio-3">OD</label>
                <!--<input type="radio" name="radio" id="radio-4" value='radio-4' required>
                <label for="radio-4">Permission</label>-->
                <input type="radio" name="radio" id="radio-5" value='radio-5' required>
                <label for="radio-5">1/2 CL</label>
                <input type="radio" name="radio" id="radio-6" value='radio-6' required>
                <label for="radio-6">1/2 OD</label>
              </fieldset>

            </div>
            <span class="subheads">Select leave dates</span>
            <div class="dtpicker">
                <form method="post" autocomplete="off">

                    <span>From: <input class="datebox" type="text" id="datepicker" name="datepicker" required></span>
                    <span>To: <input class="datebox" type="text" id="date"  name="date" required></span>
                    <!--<span class="radio-4 extra">Time: <input class="datebox" type="time" id="appt" name="appt"></span>-->
                    <span class="radio-5 extra">Shift: <select class="datebox"  name="shift"><option value="" disabled selected>--</option><option>AN</option><option>FN</option></select></span>
                    <span class="radio-6 extra">Shift: <select class="datebox" name="shift"><option value="" disabled selected>--</option><option>AN</option><option>FN</option></select></span><br>
                    <textarea placeholder="Enter reason for the leave" cols="30" rows="3" class="reason" name="Reason" required></textarea>
                    <textarea placeholder="Enter classes/faculty adjustments" cols="30" rows="3" class="reason" name="adjustment" required></textarea><br>
                    <a href="https://accounts.google.com/signin/v2/identifier?continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&service=mail&sacu=1&rip=1&flowName=GlifWebSignIn&flowEntry=ServiceLogin" target="_blank" class="btn btn-warning" role="button">Send Mail</a>
                    <button type="submit" id="submit " name="submit" class="btn btn-primary">Apply</button>
                </form>
            </div>
            
        
        </form>
        </div>
        
    </body>
</html>

