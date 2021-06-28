<?php
//fetch.php
$connect = mysqli_connect("127.0.0.1:3306", "root", "", "lmsystem2");
$columns = array('EMPID','EMPNAME', 'DEPARTMENT', 'USERNAME', 'PASSWORDS', 'CL', 'EL', 'OD', 'PERMISIONS', 'LOP', 'LATECOMING');

$query = "SELECT * FROM tblemployee ";

if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE EMPID LIKE "%'.$_POST["search"]["value"].'%" 
 OR EMPNAME LIKE "%'.$_POST["search"]["value"].'%" 
 ';
}

/**if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id DESC ';
}**/

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="EMPID">' . $row["EMPID"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="EMPNAME">' . $row["EMPNAME"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="DEPARTMENT">' . $row["DEPARTMENT"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="USERNAME">' . $row["USERNAME"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="PASSWORDS">' . $row["PASSWORDS"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="CL">' . $row["CL"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="EL">' . $row["EL"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="OD">' . $row["OD"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="PERMISIONS">' . $row["PERMISIONS"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="LOP">' . $row["LOP"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="LATECOMING">' . $row["LATECOMING"] . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM tblemployee";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>