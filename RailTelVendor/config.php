<?php session_start();
date_default_timezone_set('Asia/Kolkata');

error_reporting(0);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$host="10.63.21.6";
$user="advantage";
$pass="qwerty121";
$dbname="sarmicrosystems_advantage";
$con = new mysqli($host, $user, $pass, $dbname);


// $host="localhost";
// $user="sarmicrosystems_advantage";
// $pass="Advantage@2023";
// $dbname="sarmicrosystems_advantage";
// $con = new mysqli($host, $user, $pass, $dbname);
// Check connection
if ($con->connect_error) {
    // die("Connection failed: " . $con->connect_error);
} else {
// echo "Connected succesfull";
   
}



if (!function_exists('vendorUsersData')) {

    function vendorUsersData($id,$parameter){
        global $con;
            $sql = mysqli_query($con,"select $parameter from vendorUsers where id ='".$id."'");
            $sql_result = mysqli_fetch_assoc($sql);
            return $sql_result[$parameter];

    }
}

if (!function_exists('getVendorName')) {

    function getVendorName($id){
        global $con;
            $sql = mysqli_query($con,"select * from vendor where id ='".$id."'");
            $sql_result = mysqli_fetch_assoc($sql);
            return $sql_result['vendorName'];

    }
}


if (!function_exists('getUsername')) {

    function getUsername($id){
        global $con;
        
        $sql = mysqli_query($con,"select * from mis_loginusers where id ='".$id."'");
        $sql_result = mysqli_fetch_assoc($sql);
        
        return $sql_result['name'];
    }
    

}


$userid = $_SESSION['VENDOR_userid'];
$userLevel = $_SESSION['VENDOR_level'];
$datetime = date('Y-m-d H:i:s');
$RailTailVendorID = $_SESSION['VENDOR_RailTailVendorID'] ; 
$RailTailVendorName = getVendorName($RailTailVendorID);
$VENDOR_email = $_SESSION['VENDOR_email'];
if($userid>0){                
        $assign_cust_sql = mysqli_query($con,"select cust_id,permission from mis_loginusers where id ='".$userid."'");
        if($assign_cust_sql_result = mysqli_fetch_assoc($assign_cust_sql)){
          $assigned_customer =   $assign_cust_sql_result['cust_id'];
        }
        
            $assigned_customer = explode(',', $assigned_customer);
            $assigned_customer = json_encode($assigned_customer);
            $assigned_customer = str_replace(array('[', ']', '"'), '', $assigned_customer);
            $assigned_customer = explode(',', $assigned_customer);
            $assigned_customer = "'" . implode("', '", $assigned_customer) . "'";
                
            $menuPermission = $assign_cust_sql_result['permission'];
            $menuPermissionAr = explode(',',$menuPermission);
        
    
}





if (!function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 || 
        (substr($haystack, -$length) === $needle);
    }
}


if (!function_exists('clean')) {
function clean($string) {
  $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}

}
if (!function_exists('remove_special')) {

    function remove_special($site_remark2){
    	$site_remark2_arr = explode(" ",$site_remark2);
    	
    	foreach($site_remark2_arr as $k=>$v){
    		$a[] = preg_split ('/\n/', $v);	
    	}
    	
    	$site_remark ='' ; 
    	foreach($a as $key=>$value){
    		foreach($value as $ke=>$va){
    			$site_remark .= $va . " " ; 
    		} 
    
    	}
    
    return clean($site_remark) ; 
    
    }
    
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $requestData = json_encode($_REQUEST) ;
    $sessionData = json_encode($_SESSION) ;
    $fileData    = json_encode($_FILES) ;
    
    $dataRecordsSql = "insert into dataRecords(requestData,sessionData,fileData,created_at,created_by) 
            values('".$requestData."','".$sessionData."','".$fileData."','".$userid."','".$datetime."')";
            
            mysqli_query($con,$dataRecordsSql);
}


function loggingRecords($tableName, $id,$logTableName) {
    global $con, $userid, $datetime;
    $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id;
    $rowData = array();
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        foreach ($row as $columnName => $columnValue) {
            $rowData[$columnName] = $columnValue;
        }
    }
    $timestamp = $datetime;
    $status = "retrieved"; 
    $logSql = "INSERT INTO " . $logTableName . " (tableName, tableId, data, created_at, created_by, status,portal) 
               VALUES ('" . $tableName . "', " . $id . ", '" . json_encode($rowData) . "', '" . $timestamp . "', '" . $userid . "', '" . $status . "','" . PORTAL . "')";
    $con->query($logSql);
    return json_encode($rowData);
}



function logEvent($siteId,$atmid, $portal, $eventName, $eventDescription,$table) {
    global $con;
    $timestamp = date('Y-m-d H:i:s');
    $sql = "INSERT INTO event_log (site_id, atmid, portal, event_name, event_timestamp, event_description,tableName) 
            VALUES ($siteId,'$atmid', '$portal', '$eventName', '$timestamp', '$eventDescription','$table')";

    $con->query($sql);
}


function uploadSitesAtAdvantage($siteId,$atmid,$table) {
    logEvent($siteId, $atmid,'Advantage', 'Sites Uploaded', 'Sites uploaded at Advantage portal',$table);
}

function delegateToVendor($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Vendor', 'Sites Delegated To Vendor', 'Sites delegated to vendor for processing',$table);
}

function delegateToEngineer($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Vendor', 'Sites Delegated To Engineer', 'Sites delegated to Engineer for processing',$table);
}
function delegateToProjectExecutive($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Vendor', 'Sites Delegated To Project Executive', 'Sites delegated to Project Executive',$table);
}


function projectTeamFeasibilityCheck($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Project', 'Feasibility Check', 'Feasibility check done by project team',$table);
}

function installationProceedFromVendor($siteId,$atmid,$table){
    logEvent($siteId,$atmid, 'Vendor', 'Proceed Installation', 'Installation Request Sent To Engineer From Vendor',$table);
}

function confirmMaterialReceive($siteId,$atmid,$table){
    logEvent($siteId,$atmid, 'Vendor', 'Material Received', 'Vendor Confirm Material Receive',$table);
}



function sendMaterialToEngineer($siteId,$atmid,$table) {
    logEvent($siteId, $atmid,'Vendor', 'Material Sent', 'Material dispatch from vendor side ',$table);
}


if (!function_exists('addNotification')) {

function addNotification($senderType, $senderId, $recipientId, $message, $siteId, $atmId){
    global $con,$datetime ; 
    $senderType = $con->real_escape_string($senderType);
    $senderId = (int)$senderId;
    $recipientId = (int)$recipientId;
    $message = $con->real_escape_string($message);
    $siteId = (int)$siteId;
    $atmId = $con->real_escape_string($atmId);
    
    $sql = "INSERT INTO notifications (sender_type, sender_id, recipient_id, message, siteid, atmid,created_at) 
            VALUES ('".$senderType."', '".$senderId."', '".$recipientId."', '".$message."', '".$siteId."', '".$atmId."','".$datetime."')";

    if ($con->query($sql) === true) {

        return true;
    } else {
        return false;
    }
}
}

if (!function_exists('fetchNotificationsAndCount')) {


function fetchNotificationsAndCount($recipientType, $userid)
{
    global $con, $RailTailVendorID, $userLevel;

    // Escape the input values to prevent SQL injection
    $recipientType = $con->real_escape_string($recipientType);
    // $recipientId = (int)$recipientId;

    if ($userLevel == 1) {
        // Fetch notifications for the vendor user with $RailTailVendorID
        $sql = "SELECT * FROM notifications WHERE recipient_id = '$RailTailVendorID' and status=1 ORDER BY created_at DESC";
    } else {
        // Fetch notifications for the non-vendor user with $userid
        $sql = "SELECT * FROM notifications WHERE recipient_id = '$userid' and status=1 ORDER BY created_at DESC";
    }

    // AND sender_type != '$recipientType'
    $result = $con->query($sql);

    $notificationCount = $result->num_rows;

    if ($notificationCount > 0) {
        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }

        return ['notifications' => $notifications, 'notification_count' => $notificationCount];
    } else {
        return ['notifications' => [], 'notification_count' => 0];
    }
}
}
