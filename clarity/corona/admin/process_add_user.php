<? include('../config.php');




$sub_menu = $_REQUEST['sub_menu']; 
$sub_menu_str  = implode(',',$sub_menu) ; 


$name = $_POST['name'];
$uname = $_POST['uname'];
$pwd = $_POST['pwd'];
$contact = $_POST['contact'];
$role = $_POST['role'];
$vendorid = $_POST['vendorid'];


    $sql = "insert into user(name,uname,pwd,contact,level,user_status,permission,vendorid) 
    values('" . $name . "','" . $uname . "','" . $pwd . "','" . $contact . "','" . $role . "',1,'".$sub_menu_str."','".$vendorid."')";

if (mysqli_query($con, $sql)) { 
    echo 1 ; 

} else { 
    echo 0 ; 
} ?>


