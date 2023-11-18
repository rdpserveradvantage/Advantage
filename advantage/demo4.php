<? include('config.php');

$sql = mysqli_query($con, "SELECT * FROM `event_log` WHERE `event_name` LIKE 'Feasibility Approved'");
while ($sqlResult = mysqli_fetch_assoc($sql)) {

    $event_timestamp = $sqlResult['event_timestamp'];
    $atmid = $sqlResult['atmid'];

    $dataSql = mysqli_query($con, "SELECT * FROM `datarecords` WHERE `created_at` = '" . $event_timestamp . "'");
    $dataSqlResult = mysqli_fetch_assoc($dataSql);
    $sessionData = $dataSqlResult['sessionData'];


     $data = json_decode($sessionData) ; 
$userName = $data->ADVANTAGE_username;

$userID = $data->ADVANTAGE_userid;

mysqli_query($con,"update feasibilitycheck set verificationBy='".$userID."' ,
 verificationByName='".$userName."' where ATMID1 = '".$atmid."'");


}
?>