<?php include('config.php');

$vendorName = $_REQUEST['vendorName'];
$contactPersonName = $_REQUEST['contactPersonName'];
$contactPersonNumber = $_REQUEST['contactPersonNumber'];
$address = $_REQUEST['address'];
$POD = $_REQUEST['POD'];
$courier = $_REQUEST['courier'];
$remark = $_REQUEST['remark'];

if (isset($_POST['selectedItems'])) {
    $selectedItems = json_decode($_POST['selectedItems'], true);
    array_unique($selectedItems);
    foreach ($selectedItems as $selectedItemsKey => $selectedItemsVal) {

        $sql = mysqli_query($con, "select * from generatefaultymaterialrequest where id='" . $selectedItemsVal . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        $id = $sql_result['id'];
        $siteid = $sql_result['siteid'];
        $atmid = $sql_result['atmid'];
        $requestBy = $sql_result['requestBy'];
        $requestByPortal = $sql_result['requestByPortal'];
        $requestFor = $sql_result['requestFor'];
        $requestForPortal = $sql_result['requestForPortal'];
        $materialRequestLevel = $sql_result['materialRequestLevel'];
        $description = $sql_result['description'];
        $created_at = $sql_result['created_at'];
        $created_by = $sql_result['created_by'];
        $status = $sql_result['status'];
        $ticketId = $sql_result['ticketId'];

        $statement = "insert into generatefaultymaterialrequest(siteid,atmid,requestBy,requestByPortal,requestFor,requestForPortal,materialRequestLevel,description,created_at,created_by,status,ticketId,materialRequestType,engineer) 
        values('" . $siteid . "','" . $atmid . "','" . $requestBy . "','" . $requestByPortal . "','" . $requestFor . "','" . $requestForPortal . "','2','" . $description . "','" . $datetime . "','" . $userid . "','1','" . $ticketId . "','Clarify','" . $userid . "')
        ";

        if (mysqli_query($con, $statement)) {
            $insertId = $con->insert_id;


            mysqli_query($con, "insert into returnfaltymaterial(generatefaultymaterialrequest,portal, atmid, ticketId, contactPersonName, contactPersonNumber, address, pod, courier, remark, status, created_at, created_by) 
            values('" . $insertId . "','clarify','" . $atmid . "','" . $ticketId . "','" . $contactPersonName . "','" . $contactPersonNumber . "','" . $address . "', '" . $POD . "', '" . $courier . "', '" . $remark . "',1,'" . $datetime . "','" . $userid . "')");



            mysqli_query($con, "update generatefaultymaterialrequest set status=0 where id='" . $id . "'");
            $details_sql = mysqli_query($con, "select * from generatefaultymaterialrequestdetails where requestId='" . $id . "'");
            while ($details_sqlResult = mysqli_fetch_assoc($details_sql)) {
                $detailId = $details_sqlResult['id'];
                $MaterialID = $details_sqlResult['MaterialID'];
                $MaterialName = $details_sqlResult['MaterialName'];
                $MaterialSerialNumber = $details_sqlResult['MaterialSerialNumber'];
                $materialImage = $details_sqlResult['materialImage'];
                $created_at = $details_sqlResult['created_at'];
                $created_by = $details_sqlResult['created_by'];
                $detailStatement = "insert into generatefaultymaterialrequestdetails (requestId,MaterialID,MaterialName,MaterialSerialNumber,materialImage,created_at,created_by,status) 
                values('" . $insertId . "','" . $MaterialID . "','" . $MaterialName . "','" . $MaterialSerialNumber . "','" . $materialImage . "','" . $datetime . "','" . $userid . "',1)";
                if (mysqli_query($con, $detailStatement)) {
                    mysqli_query($con, "update generatefaultymaterialrequestdetails set status=0 where id='" . $detailId . "'");
                }
            }
            echo 1;
        }
    }
} else {
    echo 0;
}
