<?php include('config.php');
require "vendor/autoload.php";

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

if ($username && $password) {
    $response = authenticateUser( $username, $password);

    if ($response['success']) {
        // Successful authentication
        $_SESSION['SERVICE_auth'] = true;
        $_SESSION['SERVICE_isServicePortal'] = 1;
        $_SESSION['SERVICE_username'] = $response['user']['name'];
        $_SESSION['SERVICE_email'] = $response['user']['uname'];
        $_SESSION['SERVICE_userid'] = $response['user']['id'];
        $_SESSION['SERVICE_level'] = $response['user']['level'];
        
        
        $_SESSION['SERVICE_branch'] = $response['user']['branch'];
        $_SESSION['SERVICE_zone'] = $response['user']['zone'];
        $_SESSION['isServicePortalToken'] = $response['jwt'];

        // $_SESSION['SERVICE_RailTailVendorID'] = $response['user']['vendorId'];

        $response['redirect'] = 'index.php'; // Change this to your actual redirect URL
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response['success'] = false;
    $response['message'] = 'Please provide both username and password';
    header('Content-Type: application/json');
    echo json_encode($response);
}

function authenticateUser($username, $password) {
    global $con ; 
    $response = array('success' => false);

    $user = getUserFromTable(  $username, $password);


    if ($user) {
        $response['success'] = true;
        $response['user'] = $user;

        $datetime = date('Y-m-d H:i:s');
        $userid = $user['id'];
        $secret_key = "RailTailService";
        $issuedat_claim = time();
        $notbefore_claim = $issuedat_claim + 10;
        $expire_claim = $issuedat_claim + 60;
        $fname = $user['name'];
        $email = $user['uname'];

        $token = array(
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $userid,
                "fullname" => $fname,
                "email" => $email,
            )
        );
        $jwt = generateRandomString(120); // Adjust the length as needed


        $token_sql = mysqli_query($con, "update vendorUsers set token='" . $jwt . "' , updated_at = '" . $datetime . "' where id='" . $userid . "'");

        $response['jwt'] = $jwt;
    } else {
        $response['message'] = 'Invalid username or password';
    }

    return $response;
}

function getUserFromTable($username, $password) {
    global $con; 

    $table = 'mis_loginusers';
    $query = "SELECT * FROM $table WHERE (uname = '$username' OR contact = '$username') AND pwd = '$password' AND user_status = 1";    
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
    if($user){
        $_SESSION['FROM_PORTAL'] = 'Advantage';
        return $user;
    }else{
        $table = 'vendorUsers';
        $query = "SELECT * FROM $table WHERE (uname = '$username' OR contact = '$username') AND password = '$password' AND user_status = 1";    
        $result = mysqli_query($con, $query);
        $user = mysqli_fetch_assoc($result);
        $_SESSION['FROM_PORTAL'] = 'Clarify';

        return $user ; 
    }
    

}
