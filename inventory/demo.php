<? include('config.php');


$sql = mysqli_query($con, "SELECT * FROM `material_send` WHERE `atmid` in('S1NB007074037', 'S1BB006240139', 'S1BB000300386', 'S1NW000300281', 'S1NW000300156', 'S1NH000300292', 'S1NW006240142', 'S1BB007074036', 'S1BB007074044', 'S1BB007074022', 'S1NB007074043', 'S1BB007074021', 'S1BW000300382', 'S1BW000300159', 'S1NC000300294', 'S1BW006240129', 'S1NW006240161', 'S1BC000300179', 'S1NG000300285', 'S1BW000300195', 'S1BG000300209', 'S1NW000300110', 'S1NC000300350', 'S1NW000300345', 'S1BW000300163', 'S1NW001268005', 'S1NH000300352', 'S1BB000300013', 'S1BB000300155', 'S1BW000300020', 'S1NW000300214', 'S1NB000300331', 'S1NW000300324', 'S1BW000300389', 'S1BG000300024', 'S1NH007074159', 'S1NG000300326', 'S1NH007074158', 'S1BG000300199', 'S1NB000300200', 'S1NC000300339', 'S1NC000300340', 'S1NC000300356', 'S1NC000300293', 'S1NW000300354', 'S1BW000300142', 'S1NC000300351', 'S1BB000300375', 'S1NH000300355', 'S1BW006240013')");
while ($sqlResult = mysqli_fetch_assoc($sql)) {

    $id = $sqlResult['id'];
    echo $atmid = $sqlResult['atmid'];
    echo '<br>';

    $detailSql = mysqli_query($con, "select * from material_send_details where materialSendId = '" . $id . "' order by attribute asc");
    while ($detailSqlResult = mysqli_fetch_assoc($detailSql)) {

        echo $attribute = $detailSqlResult['attribute'];

        if ($attribute == 'Router') {
            $serialNumber = $detailSqlResult['value'];
        }
        echo '<br>';

    }

    mysqli_query($con,"insert into material_send_details(materialSendId,attribute,value,serialNumber,material_qty,invID)
    values('".$id."','4G ANTENNA 3MTR','','',1,'');
   ");


   mysqli_query($con,"insert into material_send_details(materialSendId,attribute,value,serialNumber,material_qty,invID)
   values('".$id."','4G ANTENNA 5MTR','','',1,'');
  ");

  echo '<br>';
    echo '<br>';


}







return;
$sql = mysqli_query($con, "select * from material_send_details");
while ($sqlResult = mysqli_fetch_assoc($sql)) {
    $id = $sqlResult['id'];
    $serialNumber = $sqlResult['serialNumber'];

    $getinvSql = mysqli_query($con, "select * from inventory where serial_no='" . $serialNumber . "'");
    $getinvSqlResult = mysqli_fetch_assoc($getinvSql);
    $materialName = $getinvSqlResult['material'];
    mysqli_query($con, "update material_send_details set attribute='" . $materialName . "' where id='" . $id . "'");
}





return;


echo "select * from material_send where 1 order by id desc";
$sql = mysqli_query($con, "select * from material_send where 1 order by id desc");
while ($sqlResult = mysqli_fetch_assoc($sql)) {
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
