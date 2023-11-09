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

if ($con->connect_error) {
    // die("Connection failed: " . $con->connect_error);
} else {
    // echo "Connected succesfull";
}

function getusername($id)
{
    global $con;
    $sql = mysqli_query($con, "select * from inventoryusers where id='" . $id . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['name'];
}



function getMaterialRequestInitiatorName($siteid)
{
    global $con;
    $sql = mysqli_query($con, "select * from material_requests where siteid='" . $siteid . "' and isProject=1");
    $sql_result = mysqli_fetch_assoc($sql);
    $vendorId = $sql_result['vendorId'];
    return getVendorName($vendorId);
}

function getMaterialRequestStatus($siteid)
{
    global $con;
    $sql = mysqli_query($con, "select status from material_requests where siteid='" . $siteid . "' and isProject=1");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['status'];
}

function getMaterial_requestData($siteid, $parameter)
{
    global $con;
    $sql = mysqli_query($con, "select $parameter from material_requests where siteid='" . $siteid . "' order by id desc");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
}





$userid = $_SESSION['userid'];
$datetime = date('Y-m-d H:i:s');

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

if (!function_exists('get_misstate')) {

    function get_misstate($id)
    {
        global $con;
        $sql = mysqli_query($con, "select * from sites where id='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result['state'];
    }

}

function logEvent($siteId, $atmid, $portal, $eventName, $eventDescription, $table)
{
    global $con;
    $timestamp = date('Y-m-d H:i:s');
    $sql = "INSERT INTO event_log (site_id, atmid, portal, event_name, event_timestamp, event_description,tableName) 
            VALUES ($siteId,'$atmid', '$portal', '$eventName', '$timestamp', '$eventDescription','$table')";

    $con->query($sql);
}


function sendMaterialToVendor($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Inventory', 'Material Sent', 'Material Sent To Vendor From Inventory', $table);
}

function confirmMaterialReceive($siteId, $atmid, $table)
{
    logEvent($siteId, $atmid, 'Inventory', 'Material Received', 'Inventory Confirm Material Received at Vendor Side', $table);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestData = json_encode($_REQUEST);
    $sessionData = json_encode($_SESSION);
    $fileData = json_encode($_FILES);

    $dataRecordsSql = "insert into dataRecords(requestData,sessionData,fileData,created_at,created_by) 
            values('" . $requestData . "','" . $sessionData . "','" . $fileData . "','" . $datetime . "','" . $userid . "')";
    mysqli_query($con, $dataRecordsSql);
}
?>