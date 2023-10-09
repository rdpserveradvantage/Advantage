<?php session_start();
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$host = "10.63.21.6";
$user = "advantage";
$pass = "qwerty121";
$dbname = "sarmicrosystems_advantage";
$con = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($con->connect_error) {
    // die("Connection failed: " . $con->connect_error);
} else {
    // echo "Connected succesfull";

}

$SERVICE_email = $_SESSION['SERVICE_email'];

if (!function_exists('vendorUsersData')) {
    function vendorUsersData($id,$parameter){
    global $con;
        $sql = mysqli_query($con,"select $parameter from vendorUsers where id ='".$id."'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result[$parameter];

}
}

function getUsers_Vendor($userid){
    global $con;
    $sql = mysqli_query($con,"select * from vendorusers where id='".$userid."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['vendorId'];
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}



if (!function_exists('getUsername')) {

    function getUsername($id, $vendor)
    {
        global $con;

        if ($vendor) {
            $sql = mysqli_query($con, "select * from vendorUsers where id ='" . $id . "'");
            $sql_result = mysqli_fetch_assoc($sql);
            return $sql_result['name'];
        } else {

            $sql = mysqli_query($con, "select * from mis_loginusers where id ='" . $id . "'");
            $sql_result = mysqli_fetch_assoc($sql);

            return $sql_result['name'];
        }
    }
}



if (!function_exists('getVendorName')) {

    function getVendorName($id)
    {
        global $con;
        $sql = mysqli_query($con, "select * from vendor where id ='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result['vendorName'];
    }
}



$userid = $_SESSION['SERVICE_userid'];
$datetime = date('Y-m-d H:i:s');
$RailTailVendorID = getUsers_Vendor($userid);
$RailTailVendorName = getUsername($RailTailVendorID, true);
$getVendorName = getVendorName($RailTailVendorID);
$SERVICE_LEVEL = $_SESSION['SERVICE_level'];
$SERVICE_email = $_SESSION['SERVICE_email'];
// if($userid>0){

//         $assign_cust_sql = mysqli_query($con,"select cust_id,permission from vendorUsers where id ='".$userid."'");
//         if($assign_cust_sql_result = mysqli_fetch_assoc($assign_cust_sql)){
//           $assigned_customer =   $assign_cust_sql_result['cust_id'];
//         }

//             $assigned_customer = explode(',', $assigned_customer);
//             $assigned_customer = json_encode($assigned_customer);
//             $assigned_customer = str_replace(array('[', ']', '"'), '', $assigned_customer);
//             $assigned_customer = explode(',', $assigned_customer);
//             $assigned_customer = "'" . implode("', '", $assigned_customer) . "'";

//             $menuPermission = $assign_cust_sql_result['permission'];
//             $menuPermissionAr = explode(',',$menuPermission);


// }





if (!function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }
}


if (!function_exists('clean')) {
    function clean($string)
    {
        $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    }
}
if (!function_exists('remove_special')) {

    function remove_special($site_remark2)
    {
        $site_remark2_arr = explode(" ", $site_remark2);

        foreach ($site_remark2_arr as $k => $v) {
            $a[] = preg_split('/\n/', $v);
        }

        $site_remark = '';
        foreach ($a as $key => $value) {
            foreach ($value as $ke => $va) {
                $site_remark .= $va . " ";
            }
        }

        return clean($site_remark);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $requestData = json_encode($_REQUEST);
    $sessionData = json_encode($_SESSION);
    $fileData    = json_encode($_FILES);

    $dataRecordsSql = "insert into dataRecords(requestData,sessionData,fileData,created_at,created_by) 
            values('" . $requestData . "','" . $sessionData . "','" . $fileData . "','" . $userid . "','" . $datetime . "')";

    mysqli_query($con, $dataRecordsSql);
}



function logEvent($siteId, $atmid, $portal, $eventName, $eventDescription, $table)
{
    global $con;
    $timestamp = date('Y-m-d H:i:s');
    $sql = "INSERT INTO event_log (site_id, atmid, portal, event_name, event_timestamp, event_description,tableName) 
            VALUES ($siteId,'$atmid', '$portal', '$eventName', '$timestamp', '$eventDescription','$table')";

    $con->query($sql);
}


function projectTeamInstallation($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Project', 'Installation', 'Installation Done By Project Team Engineer', $table);
}
function projectTeamInstallationHold($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Project', 'Installation Hold', 'Installation Hold By Project Team Engineer', $table);
}


function getInventoryIDBySerialNumber($serialNumber)
{
    global $con;
    $sql = mysqli_query($con, "Select * from inventory where serial_no='" . $serialNumber . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['id'];
}

