<? include('config.php');


$id = $_REQUEST['siteid'];
$atmid = $_REQUEST['atmid'];
$vendor = $_REQUEST['vendor'];


$scheduleAtmEngineerName = $_REQUEST['scheduleAtmEngineerName'];
$scheduleAtmEngineerNumber = $_REQUEST['scheduleAtmEngineerNumber'];
$bankPersonName = $_REQUEST['bankPersonName'];
$bankPersonNumber = $_REQUEST['bankPersonNumber'];
$backRoomKeyPersonName = $_REQUEST['backRoomKeyPersonName'];
$backRoomKeyPersonNumber = $_REQUEST['backRoomKeyPersonNumber'];
$scheduleDate = $_REQUEST['scheduleDate'];
$scheduleTime = $_REQUEST['scheduleTime'];
$sbiTicketId = $_REQUEST['sbiTicketId'];

$sql = "INSERT INTO projectInstallation (siteid, atmid, status, created_by, created_at, isDone, vendor, portal, scheduleAtmEngineerName, scheduleAtmEngineerNumber, 
                                        bankPersonName, bankPersonNumber, backRoomKeyPersonName, backRoomKeyPersonNumber,scheduleDate,scheduleTime,sbiTicketId)
        VALUES ('".$id."', '".$atmid."', 1, '".$userid."', '".$datetime."', 0, '".$vendor."', 'Advantage', '".$scheduleAtmEngineerName."', 
        '".$scheduleAtmEngineerNumber."', '".$bankPersonName."', '".$bankPersonNumber."', '".$backRoomKeyPersonName."', '".$backRoomKeyPersonNumber."','".$scheduleDate."','".$scheduleTime."','".$sbiTicketId."')";
        
        if(mysqli_query($con,$sql)){
            echo json_encode(202);
            installationProceed($id,$atmid,'');
        }


?>