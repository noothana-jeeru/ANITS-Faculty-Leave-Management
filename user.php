<?php
session_start();


 if((array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID'] !=3555) && (array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID'] !=3666)) {
        
        
       
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
        <title>Home</title>
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
            .content {
                
                margin-left: 15%;
                padding-top: 65px;
                
            }
            .dev {
                float: right;
                margin-top: 20px;
                margin-right: 10px;
            }
            .guide{
                
                display: contents;
                height: 400px;
                width: 100px;
                background-color: #DCDCDC;
                padding: 30px 55px 30px 55px;
                margin-top: 5px;
                border-radius: 15px;
                
                
            }
            ul {
                list-style: square;
            }
            #carouselExampleIndicators {
                width: 900px;
                margin-left: 15%;
            }
            h3 {
                text-align: center;
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
                  <button type="button" class="list-group-item active list-group-item-action">Home</button>
                  <button type="button" class="list-group-item list-group-item-action" onclick="location.href='apleave.php'">Apply Leave</button>
                  <button type="button" class="list-group-item list-group-item-action" onclick="location.href='leavestatus.php'">My Leaves status</button>
                  
                  <button type="button" class="list-group-item list-group-item-action"onclick="location.href='holidayslist.php'">Holidays List</button>
            </div>
             
        </div>
        
        <div class="content">
            
             <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
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
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-block w-100 guide" alt="Guidelines">
                            <h3>Guidelines</h3>
                            <ul>
                                <li>CL - Casual Leave, EL - Earned Leave, OD - On Duty. </li>
                                <li>Only 4 CLs can be used at a time. If more are used, LOPs will be increased. </li>
                                <li>While applying for ELs, if there are any holidays in between the choosen dates, they will also be counted as leave(s). </li>
                                <li>While 1 leave request is in INPROCESS state, another leave request cannot be made <strong>(1/2CL, 1/2EL are exceptions)</strong>. </li>
                                <li>A user can Cancel their own leave request while it is still in INPROCESS state.</li>
                                <li>While making a leave request, a user should fill the Adjustments field in the following format :<br>
                                    <strong>Faculty to whom the class is assigned, Year and Section, Period.</strong></li>
                                <li>While making a leave request, a user should send their classes adjustments to the corresponding faculty through <strong>'Send Mail'</strong> option before clicking <strong>'Apply'</strong>. </li>
                            </ul>
                        </div>
                    </div>
                    <div class="carousel-item">
                      <div class="d-block w-100 guide" alt="Guidelines">
                            <h3>Example Scenarios</h3>
                            <ul>
                                <li>First, 1 EL was applied on Saturday then immediately on Monday if another 1 EL was applied, then total leaves used will be equal to 3, as Sunday is a holiday.</li>
                                <li>To apply leave for 2.5 days, first make leave request for 2 days using CLs (or) ODs, then again make a leave request for 0.5 day, by using 1/2CL (or) 1/2OD options.<strong>(same can be done for 1.5 days,3.5 days,etc.)</strong> </li>
                                <li>If 2 Permissions were used, then if 3rd Permission is applied then 0.5 CL will be deducted, and if 4th Permission is applied then no CL will be deducted<strong>(i.e., 0.5 CL will be deducted on every odd extra permission leave request)</strong>. </li>
                                <li>If, leave request was made and approved for 2 days, then if you want to extend/reduce number of days of leave, Go to <strong>My Leave Status->Edit Last Leave</strong>, and make a edited request.</li>
                            </ul>
                        </div>
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
            </div>
            <div class="dev">
                © Developed by students of Information Technology 2018-2022.
            </div>
            
        </div>
    </body>
</html>
