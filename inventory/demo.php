<? include('config.php');

echo "select * from material_send where 1 order by id desc" ;
$sql = mysqli_query($con,"select * from material_send where 1 order by id desc") ; 
while($sqlResult = mysqli_fetch_assoc($sql)){
    $id = $sqlResult['id'];

    $detailsQuery = "SELECT * FROM material_send_details WHERE materialSendId = $id";
    $detailsResult = mysqli_query($con, $detailsQuery);

    while ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
        $attribute = $detailsRow['attribute'];
        echo $serialNumber = $detailsRow['serialNumber'];
        
        $inventorySql = mysqli_query($con, "select * from Inventory where serial_no='" . $serialNumber . "'");
        $inventorySqlResult = mysqli_fetch_assoc($inventorySql);

        $material = $inventorySqlResult['material'];
        $material_make = $inventorySqlResult['material_make'];
        $model_no = $inventorySqlResult['model_no'];
        $serial_no = $inventorySqlResult['serial_no'];
        $challan_no = $inventorySqlResult['challan_no'];
        $amount = $inventorySqlResult['amount'];
        $gst = $inventorySqlResult['gst'];
        $amount_with_gst = $inventorySqlResult['amount_with_gst'];


        $vendorInventorySql = "insert into vendorInventory(vendorId, material, material_make, model_no, serial_no,  amount, gst, amount_with_gst, 
        courier_detail, tracking_details,  created_at, created_by, status) 
        values('1','" . $material . "', '" . $material_make . "', '" . $model_no . "', '" . $serial_no . "',  '" . $amount . "',
        '" . $gst . "', '" . $amount_with_gst . "', '" . $courier . "', '" . $po_number . "', '" . $datetime . "', '" . $userid . "',0)";

        $result = mysqli_query($con, $vendorInventorySql);
        
    }
    echo '<br><br>';

}
