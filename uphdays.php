 <?php 

session_start();
       
           
     if((array_key_exists("EMPID", $_SESSION) AND $_SESSION['EMPID']==3666))
     {
        
      
}
else {
        
        header("Location: index.php");
                 
}

$connect = mysqli_connect("127.0.0.1:3306", "root", "", "lmsystem2");
$query = "SELECT * FROM holydays";
$result = mysqli_query($connect, $query);


?>


<!DOCTYPE html>
<html>
     <head>
          <title>Live Add Edit Delete Datatables Records using PHP Ajax</title>
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
          <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
          <style>
          body
          {
           margin:0;
           padding:0;
           background-color:#f1f1f1;
          }
          .box
          {
           width:1270px;
           padding:20px;
           background-color:#fff;
           border:1px solid #ccc;
           border-radius:5px;
           margin-top:25px;
           box-sizing:border-box;
          }
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
            .nav{
                  padding-top: 30px;
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
              <li role="presentation"><a href="upuser.php">Update User Details</a></li>
              <li role="presentation" class="active"><a href="uphdays.php">Update Holidays</a></li>
              <li role="presentation"><a href="adminremarks.php">Add Remarks</a></li>
              <li role="presentation" class="navbar-text" style="float:right">ID : <?php echo $_SESSION['EMPID'];?></li>
              <li role="presentation" class="navbar-text" style="float:right">Name : <?php echo $_SESSION['EMPNAME'];?></li>
            </ul>
             
         </div>
         
         <div class="container box">
               <h1 align="center">Update Holidays</h1>
               <br />
               <div class="table-responsive">
                   <br />
                    <div align="right">
                     <button type="button" name="add" id="add" class="btn btn-info">Add</button>
                    </div>
                    <br />
                    <div id="alert_message"></div>
                    <table id="user_data" class="table table-bordered table-striped">
                     <thead>
                      <tr>
                       <th>DATEs</th>
                       <th>DESCRIPTIONs</th>
                       <th>Action</th>
                      </tr>
                     </thead>
                    </table>
               </div>
          </div>
     </body>
</html>

<script type="text/javascript" language="javascript" >
     $(document).ready(function(){

      fetch_data();

      function fetch_data()
      {
       var dataTable = $('#user_data').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
         url:"fetch.php",
         type:"POST"
        }
       });
      }

      function update_data(id, column_name, value)
      {
       $.ajax({
        url:"update.php",
        method:"POST",
        data:{id:id, column_name:column_name, value:value},
        success:function(data)
        {
         $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
         $('#user_data').DataTable().destroy();
         fetch_data();
        }
       });
       setInterval(function(){
        $('#alert_message').html('');
       }, 5000);
      }

      $(document).on('blur', '.update', function(){
       var id = $(this).data("id");
       var column_name = $(this).data("column");
       var value = $(this).text();
       update_data(id, column_name, value);
      });

      $('#add').click(function(){
       var html = '<tr>';
       html += '<td contenteditable id="data1"></td>';
       html += '<td contenteditable id="data2"></td>';
       html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
       html += '</tr>';
       $('#user_data tbody').prepend(html);
      });

      $(document).on('click', '#insert', function(){
       var DATEs = $('#data1').text();
       var DESCRIPTIONs = $('#data2').text();
       if(DATEs != '' && DESCRIPTIONs != '')
       {
        $.ajax({
         url:"insert.php",
         method:"POST",
         data:{DATEs:DATEs, DESCRIPTIONs:DESCRIPTIONs},
         success:function(data)
         {
          $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
          $('#user_data').DataTable().destroy();
          fetch_data();
         }
        });
        setInterval(function(){
         $('#alert_message').html('');
        }, 5000);
       }
       else
       {
        alert("Both Fields is required");
       }
      });

      $(document).on('click', '.delete', function(){
       var id = $(this).attr("id");
       if(confirm("Are you sure you want to remove this?"))
       {
        $.ajax({
         url:"delete.php",
         method:"POST",
         data:{id:id},
         success:function(data){
          $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
          $('#user_data').DataTable().destroy();
          fetch_data();
         }
        });
        setInterval(function(){
         $('#alert_message').html('');
        }, 5000);
       }
      });
     });
</script>

