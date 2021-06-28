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
                    if($_POST['radio'] != 'radio-5' AND $_POST['radio'] != 'radio-6')
                    {
                    $q =  mysqli_query($link,("SELECT * FROM `tblleave` WHERE LEAVESTATUS='INPROCESS'AND EMPID = '".$_SESSION['EMPID']."' 
                                   "));
                                   $u = mysqli_fetch_array($q);
                    }
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

if(($_POST['radio'] == 'radio-1') AND $mindate!=date("Y-m-d"))
{
 /* this is the session elements which comes from db noOf cl's*/
 $cl= $update['CL'];
 $elmax=$update['EL'];
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
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Casual Leave')  ");
    
        $message="";
        $message .="$applied CLs Used. ";
        $message .="Leave Submitted.";
    
    
    //header("Location:redirect.php");
  }
 
 else if($workingdays>$clmax AND $count != 0 )
  {
     
     
 if($elmax!=0 AND $cl==0)
    {
     $message="";
     $message .="You have $clmax CLs, but having $elmax ELs so you can use ELs. ";
     $message .="Leave not Submitted.";
    } 
    else
    {
      
    $lop=$workingdays-$clmax;
    //print_r($lop);
   $noofdays=$lop+$clmax;
     $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,CL_USED,LOP__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$clmax,$lop,$noofdays,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay')  ");

     $message="";
     $message .="You can use only $clmax CLs, so you have used $lop LOPs. ";
     $message .="Leave Submitted.";
    }
    
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
else if(($_POST['radio'] == 'radio-1') AND $mindate == date("Y-m-d"))
  {
    $message="";
    $message .="CLs should be applied atleast before one day. ";
    $message .="Leave not Submitted. ";
  } 





else if(($_POST['radio'] == 'radio-2') AND $mindate>date("Y-m-d",strtotime("+1 days")))
 {
 /* this is the session elements which comes from db noOf el's*/
  $elmax=$update['EL'];
  $cl= $update['CL'];

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
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Earned Leave')  ");
    
     
     $message="";
     $message .="$applied ELs used. ";
     $message .="Leave Submitted.";
      
    }
    
   else 
   {
       
      $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,EL_USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Earned Leave')  ");

     $message="";
     $message .="$count ELs used. ";
     $message .="Leave Submitted.";
   }

  
  }
   else if($count>$elmax AND $count != 0)
  {
    
 if($cl!=0 AND $elmax==0)
    {
     $message="";
     $message .="You have $elmax ELs, but having $cl CLs so you can use CLs. ";
     $message .="Leave not Submitted.";
    } 
    else
    {
    $lop=$count-$elmax;
    //print_r($lop);
   $noofdays=$lop+$elmax;
     $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,EL_USED,LOP__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$elmax,$lop,$noofdays,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay')  ");
 
    $message="";
    $message .="You have only $elmax ELs, so you have used $lop LOPs. ";
    $message .="Leave Submitted.";
  }

  }  
  else
  {
    $message="";
    $message .="You have selected dates in inappropriate order. ";
    $message .="Leave not Submitted.";
  }

 }
 else if(($_POST['radio'] == 'radio-2') AND $mindate <= date("Y-m-d",strtotime("+1 days")))
  {
    $message="";
    $message .="ELs should be applied atleast before two days. ";
    $message .="Leave not Submitted. ";
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
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','On Duty')  ");
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




else if(($_POST['radio'] == 'radio-4') AND $_POST['appt'])
  {

  $pmax=$update['PERMISIONS'];

   $alldates=createDateRange($mindate, $maxdate);

   $count = count($alldates);
  
  
  if($count<=$pmax AND $count != 0 AND $count<=1)
  {
    $applied=$count;
   

     
   $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,PERMISIONS__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE,TIME) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Permission',
                                   '".$_POST['appt']."')  ");
    $message="";
    $message .="$applied Permission used. ";
    $message .="Leave Submitted.";

   

 $R1=1;
    //echo( $R1);
    mysqli_query($link,("UPDATE `tblemployee` SET PERMISIONFLAG='{$R1}' WHERE 
                                                                                        EMPID = '".$_SESSION['EMPID']."' "));




  }
    else if($count>1 AND $count != 0)
  {
    
    $message="";
    $message .="You can't use more than 1 Permission. ";
    $message .="Leave not Submitted.";
    
  }


  else if($pmax==0 AND  $update['CL']!=0)
  {
  


  $query=mysqli_query($link,("SELECT PERMISIONFLAG from `tblemployee` WHERE EMPID = '".$_SESSION['EMPID']."' "));
   $flag = mysqli_fetch_array($query);
   
  if($flag['PERMISIONFLAG']==1)
  {
   $applie=0.5;
   $applied=floatval($applie);

    $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,EXTRAPER__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE,TIME) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applie,$applie,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Extra Permission','".$_POST['appt']."')  ");
    $message="";
    $message .="Extra permission is used, so $applied CL used. ";
    $message .="Leave Submitted.";

    

   
  }
    else
    {

 $applie=0.0;
   $applied=floatval($applie);

    $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,EXTRAPER__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE,TIME) 
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applie,0.5,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Extra Permission','".$_POST['appt']."')  ");
    $message="";
    $message .="Extra permission is used, so $applied CL used. ";
    $message .="Leave Submitted.";

 
    }

  



 
   //print_r($flag);

  }
 
 elseif ($update['CL']==0) 
 {
   
   //echo"LOP ";
 $query=mysqli_query($link,("SELECT PERMISIONFLAG from `tblemployee` WHERE EMPID = '".$_SESSION['EMPID']."' "));
   $flag = mysqli_fetch_array($query);
   
  if($flag['PERMISIONFLAG']==1)
  {
   $applie=0.5;
   $applied=floatval($applie);
    $key=1;

    $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,LOP__USED,EXTRAPER__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE,TIME) 
                          VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),'$applie','$applie','$applie','".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay','".$_POST['appt']."')");
    
   
  }
    else
    {

 $applie=0.0;
   $applied=floatval($applie);
   $key=1;

    $query =  mysqli_query($link," INSERT INTO `tblleave`(EMPID,DATESTART,DATEEND,LEAVESTATUS,DATEPOSTED,LOP__USED,EXTRAPER__USED,NOOFDAYS,REASON,ADJUSTMENT,EMPNAME,TYPEOFLEAVE ,TIME)
                           VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),'$applie','$applie','$applie','".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay','".$_POST['appt']."')");
     
    }




 }
   else
  {
    $message="";
    $message .="You have selected dates in inappropriate order. ";
    $message .="Leave not Submitted.";
  } 
 }
 else if(($_POST['radio'] == 'radio-5') AND $_POST['shift'])
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
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applied,$applie,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Casual Leave','".mysqli_real_escape_string($link, $_POST['shift'])."')  ");
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
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$lop,$lop,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay','".mysqli_real_escape_string($link, $_POST['shift'])."')  ");
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
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$applied,$applied,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','On Duty','".mysqli_real_escape_string($link, $_POST['shift'])."')  ");
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
                                   VALUES('{$_SESSION['EMPID']}','{$mindate}','{$maxdate}','INPROCESS',CURDATE(),$lop,$lop,'".mysqli_real_escape_string($link, $_POST['Reason'])."','".mysqli_real_escape_string($link, $_POST['adjustment'])."','".mysqli_real_escape_string($link, $_SESSION['EMPNAME'])."','Loss Of Pay','".mysqli_real_escape_string($link, $_POST['shift'])."')  ");
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
                $( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+1M +10D" });
              } );
            
            $( function() {
                $( "#date" ).datepicker({ minDate: 0, maxDate: "+1M +10D" });
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
                margin-top: 0;
                margin-right: auto;
                margin-bottom: 10px;
                margin-left: auto;
                width: 400px;
                background-color: #fff0d4;
                border-radius: 15px;
            }
            .counterstable{
                margin-top: 0px;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 0px;
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
            .content {
                
                margin-left: 15%;
                padding-top: 65px;
                
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
            <button id="logout" type="button" class="btn btn-dark" onclick="location.href='logout.php'">Log out</button>
            
        </div>
        <div class="sidebar">
            <div class="profile">
                <p class="id">ID : <?php echo $_SESSION['EMPID'];?></p>
                <p class="name">Name : <?php echo $_SESSION['EMPNAME'];?></p>
                <p class="department">Department : IT</p>
            </div>
            
            <div id="actions" class="list-group">
                  <button type="button" class="list-group-item list-group-item-action" onclick="location.href='redirect.php'">Home</button>
                  <button type="button" class="list-group-item active list-group-item-action" >Apply Leave</button>
                  <button type="button" class="list-group-item list-group-item-action" onclick="location.href='leavestatus.php'">My Leaves status</button>
                  
                  <button type="button" class="list-group-item list-group-item-action"onclick="location.href='holidayslist.php'">Holidays List</button>
                
            </div>
             
        </div>
        
        <div class="content">
            
             <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Apply Leave</li>
              </ol>
            </nav>
            <div class="counters">
                
                <table class="counterstable table table-borderless">
                  <thead>
                    <tr>
                      <th style="text-align:center" scope="col">CL</th>
                      <th style="text-align:center" scope="col">EL</th>
                      <th style="text-align:center" scope="col">OD</th>
                      <th style="text-align:center" scope="col">Permissions</th>
                      <th style="text-align:center" scope="col">LOP</th>
                      <th style="text-align:center" scope="col">LateComing</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td style="text-align:center"><button type="button" class="btn btn-dark btn-lg">  <?php echo $update['CL'];?></button></td>
                        <td style="text-align:center"><button type="button" class="btn btn-dark btn-lg"><?php echo $update['EL'];?></button></td>
                        <td style="text-align:center"><button type="button" class="btn btn-dark btn-lg"><?php echo $update['OD'];?></button></td>
                        <td style="text-align:center"><button type="button" class="btn btn-dark btn-lg"><?php echo $update['PERMISIONS'];?></button></td>
                        <td style="text-align:center"><button type="button" class="btn btn-dark btn-lg"><?php echo $update['LOP'];?></button></td>
                        <td style="text-align:center"><button type="button" class="btn btn-dark btn-lg"><?php echo $update['LATECOMING'];?></button></td>
                    </tr>
                  </tbody>
                  <tbody>
                    <tr>
                        <td style="text-align:center">Left</td>
                        <td style="text-align:center">Left</td>
                        <td style="text-align:center">Left</td>
                        <td style="text-align:center">Left</td>
                        <td style="text-align:center">Used</td>
                        <td style="text-align:center">Marked</td>
                    </tr>
                  </tbody>
                </table>
                
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
                <input type="radio" name="radio" id="radio-4" value='radio-4' required>
                <label for="radio-4">Permission</label>
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
                    <span class="radio-4 extra">Time: <input class="datebox" type="time" id="appt" name="appt"></span>
                    <span class="radio-5 extra">Shift: <select class="datebox" name="shift"><option value="" disabled selected>--</option><option>AN</option><option>FN</option></select></span>
                    <span class="radio-6 extra">Shift: <select class="datebox" name="shift"><option value="" disabled selected>--</option><option>AN</option><option>FN</option></select></span>
                    <br>
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