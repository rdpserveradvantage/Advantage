<? include('config.php');


$sql = mysqli_query($con, "SELECT * FROM material_send where vendorId='2'");
while ($sqlResult = mysqli_fetch_assoc($sql)) {
    echo $id = $sqlResult['id'];
    echo '<br>';

    $sq = mysqli_query($con, "select * from material_send_details where materialSendId='" . $id . "'");
    while ($sqResult = mysqli_fetch_assoc($sq)) {
        echo $attribute = $sqResult['attribute'];
        echo ' - ';
        
        echo $serialNumber = $sqResult['serialNumber'];

        echo '<br>';


        $vendorInventorySql = "insert into vendorInventory(vendorId, material, material_make, model_no, serial_no,  amount, gst, amount_with_gst, 
        courier_detail, tracking_details,  created_at, created_by, status) 
        values('2','" . $attribute . "', '" . $material_make . "', '" . $model_no . "', '" . $serial_no . "',  '" . $amount . "',
        '" . $gst . "', '" . $amount_with_gst . "', '" . $courier . "', '" . $po_number . "', '" . $datetime . "', '" . $userid . "',0)";


    }

    echo '<br>';
    echo '<br>';

}




return;

$sql = mysqli_query($con, "SELECT * FROM `inventory` WHERE `material` LIKE 'Lan Cable'");
$sqlResult = mysqli_fetch_assoc($sql);

$material = $sqlResult['material'];
$material_make = $sqlResult['material_make'];
$model_no = $sqlResult['model_no'];
$serial_no = $sqlResult['serial_no'];
$challan_no = $sqlResult['challan_no'];
$amount = $sqlResult['amount'];
$gst = $sqlResult['gst'];
$amount_with_gst = $sqlResult['amount_with_gst'];
$courier_detail = $sqlResult['courier_detail'];
$tracking_details = $sqlResult['tracking_details'];
$date_of_receiving = $sqlResult['date_of_receiving'];
$receiver_name = $sqlResult['receiver_name'];
$vendor_name = $sqlResult['vendor_name'];
$vendor_contact = $sqlResult['vendor_contact'];
$po_date = $sqlResult['po_date'];
$po_number = $sqlResult['po_number'];
$created_at = $sqlResult['created_at'];
$created_by = $sqlResult['created_by'];
$updated_at = $sqlResult['updated_at'];
$status = $sqlResult['status'];
$inventoryType = $sqlResult['inventoryType'];
$isIPAssign = $sqlResult['isIPAssign'];


for ($i = 0; $i < 14; $i++) {
    echo $sql = "insert into inventory(material,material_make,model_no,serial_no,challan_no,amount,gst,amount_with_gst,courier_detail,tracking_details,date_of_receiving,receiver_name,vendor_name,vendor_contact,po_date,po_number,created_at,created_by,updated_at,status,inventoryType,isIPAssign)
    values('" . $material . "','" . $material_make . "','" . $model_no . "','" . $serial_no . "','" . $challan_no . "','" . $amount . "',
'" . $gst . "','" . $amount_with_gst . "','" . $courier_detail . "','" . $tracking_details . "','" . $date_of_receiving . "',
'" . $receiver_name . "','" . $vendor_name . "','" . $vendor_contact . "','" . $po_date . "','" . $po_number . "','" . $created_at . "',
'" . $created_by . "','" . $updated_at . "','" . $status . "','" . $inventoryType . "','" . $isIPAssign . "');
";
    mysqli_query($con, $sql);

}

