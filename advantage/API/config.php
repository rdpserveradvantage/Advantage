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

function projectTeamFeasibilityCheck($siteId,$atmid,$table) {
    logEvent($siteId,$atmid, 'Project', 'Feasibility Check', 'Feasibility check done by project team',$table);
}