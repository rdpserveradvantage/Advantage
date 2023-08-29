<?php include('config.php');

// // ini_set('display_errors', 1);
// // ini_set('display_startup_errors', 1);
// // error_reporting(E_ALL);


// var_dump($_REQUEST);
// Initialize response arrays
$response = array();
$response['success'] = false;
$response['message'] = "";

$status = 'open';
$created_by = $userid;

$created_at = $datetime;
$atmid = $_POST['atmid'];
$bank = $_POST['bank'];
$customer = $_POST['customer'];
$zone = $_POST['zone'];
$city = $_POST['city'];
$state = $_POST['state'];
$location = $_POST['location'];
$branch = $_POST['branch'];
$bm = $_POST['bm'];

$remarks = htmlspecialchars($_POST['remarks']);
$comp = $_POST['comp'];
$subcomp = $_POST['subcomp'];
$docket_no = $_POST['docket_no'];
$call_type = $_REQUEST['call_type'];

$fromtime = $_REQUEST['fromtime'];
$totime = $_REQUEST['totime'];
$engineer_user_id = $_REQUEST['engineer'];

$serviceExecutive = $_SESSION['SERVICE_username'];
$lho = $_REQUEST['lho'];

if($_SESSION['SERVICE_level']==5){
    $call_receive = 'Customer / Bank';
}else{
    $call_receive = $_POST['call_receive'];
}

$statement = "INSERT INTO mis(atmid, bank, customer, zone, city, state, location, call_receive_from, remarks, status, created_by, created_at, branch, bm, call_type, serviceExecutive,lho) 
VALUES ('".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$call_receive."','".$remarks."','open','".$created_by."','".$created_at."','".$branch."','".$bm."','".$call_type."','".$serviceExecutive."','".$lho."')";

if(mysqli_query($con,$statement)) {
    $mis_id = $con->insert_id;

            $last_sql = mysqli_query($con,"select id from mis_details order by id desc");
            $last_sql_result = mysqli_fetch_assoc($last_sql);
            $last = $last_sql_result['id'];
            
            if(!$last){
                $last=0;
            }
            $ticket_id =  mb_substr(date('M'), 0, 1).date('Y') .date('m')  . date('d') . sprintf('%04u', $last) ;
            

            
             $detai_statement = "insert into mis_details(mis_id,atmid,component,subcomponent,engineer,docket_no,status,created_at,ticket_id,
             mis_city,zone,call_type,case_type,branch) 
             values('".$mis_id."','".$atmid."','".$comp."','".$subcomp."','".$engineer_user_id."','".$docket_no[$i]."','".$status."','".$created_at."','".$ticket_id."','".$mis_city."','".$zone."','Service','".$call_receive."','".$branch."')" ;
            if(mysqli_query($con,$detai_statement)){ 
            
        }       
    

    $response['success'] = true;
    $response['message'] = "Call Logged successfully ! TICKET ID : "  . $ticket_id ;
    
} else {
    $response['message'] = "An error occurred while saving the form data.";
}

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($response);