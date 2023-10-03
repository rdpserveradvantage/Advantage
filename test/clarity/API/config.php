<?php 
date_default_timezone_set('Asia/Kolkata');

error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json; charset=utf-8');


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

if ($con->connect_error) {
    // die("Connection failed: " . $con->connect_error);
} else {
    // echo "Connected succesfull";
}

$date = date('Y-m-d');
$created_at = $datetime = date('Y-m-d h:i:s');



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

function addSD($siteid,$atmid,$userid,$type,$scheduleDatetime){
    global $con,$datetime;
    
    mysqli_query($con,"insert into scheduleASDESDHistory(siteid,atmid,userid,portal,type,scheduleDatetime,created_at,status)
    values('".$siteid."','".$atmid."','".$userid."','Project','".$type."','".$scheduleDatetime."','".$datetime."',1)
    ");
}


function uploadSitesAtAdvantage($siteId,$atmid,$table) {
    logEvent($siteId, $atmid,'Advantage', 'Sites Uploaded', 'Sites uploaded at Advantage portal',$table);
}

function delegateToVendor($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Vendor', 'Sites Delegated To Vendor', 'Sites delegated to vendor for processing',$table);
}

function delegateToEngineer($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Vendor', 'Sites Delegated To Engineer', 'Sites delegated to vendor for processing',$table);
}

function engineerESD($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Project', 'Update ESD', 'Engineer Update Estimated Schedule Date',$table);
}
function engineerASD($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Project', 'Update ASD', 'Engineer Update Actual Schedule Date',$table);
}

function projectTeamFeasibilityCheck($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Project', 'Feasibility Check', 'Feasibility check done by project team',$table);
}