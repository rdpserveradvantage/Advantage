<? include('config.php');

$serializedAttributes = $_POST['attribute'];
$serializedValues = $_POST['values'];
$serializedSerialNumbers = $_POST['serialNumbers'];

$attributes = unserialize($serializedAttributes);
$values = unserialize($serializedValues);
$serialNumbers = unserialize($serializedSerialNumbers);

$materialSendIDParent = $_POST['materialSendID'];

$atmid = $_POST['atmid'];
$siteid = $_POST['siteid'];
$vendorId = $_POST['vendorId'];
$contactPersonName = $_POST['contactPersonName'];
$contactPersonNumber = $_POST['contactPersonNumber'];
$address = $_POST['address'];
$pod = $_POST['POD'];
$courier = $_POST['courier'];
$remark = $_POST['remark'];

var_dump($_SESSION) ; 
return ; 
$statement = "insert into goodreturn(siteid,atmid,created_at,created_by,portal,status,remarks) 
values('" . $siteid . "','" . $atmid . "','" . $datetime . "','" . $userid . "','vendor','1','" . $remark . "')";
if (mysqli_query($con, $statement)) {
    $insert_id = $con->insert_id;
    for ($i = 0; $i < count($attributes); $i++) {
        mysqli_query($con, "insert into goodreturndetails(goodReturnID,material,serialNumber) 
        values('" . $insert_id . "','" . $attributes[$i] . "','" . $serialNumbers[$i] . "')");
    }

    mysqli_query($con,"insert into (materialSendId,atmid,siteid,challanNumber,receiversName,receiversNumber,,created_at,portal,status)
    values('".$materialSendIDParent."','".$atmid."','".$siteid."','".$pod."','".$receiversName."','".$receiversNumber."','".$datetime."','vendor','1')
    ")
}

