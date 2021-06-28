<?php

session_start();

   
     $error = "";  

       if(array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID']==3555){
        
        header("Location:hod.php");

        }
        
        else if(array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID']==3666){
        
        header("Location:upuser.php");

        }
        
        else if((array_key_exists("email", $_SESSION) AND $_SESSION['email'])){
            
            header("Location:user.php");
            
        }
        
    
        if (array_key_exists("submit", $_POST)) {
        
        $link=mysqli_connect("127.0.0.1:3306","root","","lmsystem2");

        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
         
      
        
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>" .$error;
            
        } else {
            
              if($_POST['signUp'] == '1') {
                    
                    $query = "SELECT * FROM `tblemployee` WHERE USERNAME = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);

                   
                
                   
                    if (isset($row)) {
                        
                        $hashedPassword = $_POST['password'];
                        
                        if ($hashedPassword == $row['PASSWORDS']) {
                             
                             $_SESSION['CL'] = $row['CL'];
                             $_SESSION['EL'] = $row['EL'];
                             $_SESSION['OD'] = $row['OD'];
                             $_SESSION['PERMISIONS'] = $row['PERMISIONS'];
                             $_SESSION['LOP'] = $row['LOP'];
                             $_SESSION['email'] = $_POST['email'];

                            // $_SESSION['EMPID'] = $row['EMPID'];
                             $_SESSION['EMPNAME'] = $row['EMPNAME'];
                             if($row['EMPID']==3555)
                            {                            
                            $_SESSION['EMPID'] = $row['EMPID'];
                            header("Location:hod.php");
                            }
                            
                            else if($row['EMPID']==3666)
                            {                            
                            $_SESSION['EMPID'] = $row['EMPID'];
                            header("Location:upuser.php");
                            }
                               
                            else
                            {
                            $_SESSION['EMPID'] = $row['EMPID'];
                           
                            header("Location:user.php");
                            } 
                        } else {
                            
                            $error .= "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error .= "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }



?>



<!DOCTYPE html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<html lang="en">
<head profile="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg">
        <link rel="icon" 
      type="image/png" 
      href="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js" integrity="sha256-eiohPQlDytO6qQO+k+xX6LyVgfXcTzlPCy9t/VjceYo=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/d3js/5.15.1/d3.min.js"></script>
<title>Leave Management Portal</title>
    
<style>
    
    .splitleft {
      height: 100%;
      width: 50%;
      position: fixed;
      z-index: -1;
      top: 0;
      overflow-x: hidden;
      padding-top: 20px;
      left: 0;
      background-image: radial-gradient(#eeeeee,gray);
      opacity: 0.9;
      text-align: center;
      filter: blur(0px);

    }
    .centeredleft {
      
      position: absolute;
      top: 50%;
      left: 25%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .splitright {
      height: 100%;
      width: 50%;
      position: fixed;
      z-index: -1;
      top: 0;
      overflow-x: hidden;
      padding-top: 20px;
      right: 0;
      background-image: linear-gradient(lightgray,#e6e6e6e6);
      filter:blur(2px);
    }

    .centeredright {
      position: absolute;
      top: 50%;
      left: 75%;
      transform: translate(-50%, -50%);
    }

    .logo {

    border-radius: 15px;
    width : 200px;
    z-index: 2;

    }
    .center {

        position: absolute;
        left: 39%;
    }
    .login {

        background-color: rgba(238,238,238,0.6);
        border-radius: 15px;
        border: 1px solid grey;
        width: 300px;
        height: 300px;
        padding: 25px;
        box-shadow: 5px 5px 8px #888888;

    }
    h3{
        margin-bottom: 20px;
    }
    .myalert{
        
        background-color: #f8d7da;
        padding-top: 10px;
        border: 0;
        border-radius: 5px;
        display: inline-block !important;
    }
    .dev {
                float: right;
                margin-top: 735px;
                margin-right: 10px;
            }
    
</style>
</head>
<body>

    
    
<div class="centeredleft">
    <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Anits_logo.jpg" alt="Anits Logo">
    <h3>Leave Management Portal</h3>
</div>
<div class="splitleft">
  
</div>

<div class="centeredright">
    
    <form class="login" method="post">
        
        <div style="display:none" class="myalert"><?php echo $error; ?></div>
        
        <h3>Sign In</h3>
    
        <fieldset class="form-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="Username" autocomplete="off" required>
        </fieldset>
    
        <fieldset class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required >
        </fieldset>
         <input type="hidden" name="signUp" value="1">
        <button type="submit" id="submit " name="submit"  class="btn btn-primary center" >Login</button>
    
    </form>

  </div>
<div class="splitright">
  
</div>
<div class="dev">
     © Developed by students of Information Technology 2018-2022.
 </div>

</body>
</html>
