<?php
// Include your database configuration file
include('config.php');

// Include PhpSpreadsheet library
require 'vendor/autoload.php';

// Import necessary classes from PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Excel spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


// Define and execute your database query to fetch data
$exportSql = $_REQUEST['exportSql']; // Replace with your SQL query
$sql_app = mysqli_query($con, $exportSql); // Execute the SQL query





// Define column headers
$headers = array(
    'Srno',
    'ATMID',
    'Status',
    'Actions',
    'Vendor',
    'Address',
    'Contact_Person',
    'Contact_Number',
    'POD',
    'Courier',
    'Remark',
    'Date',
);


$boqSql = mysqli_query($con, "select * from boq where status=1");
while ($boqSqlResult = mysqli_fetch_assoc($boqSql)) {
    $attributeAr[] = trim($boqSqlResult['value']);
    $headers[] = trim($boqSqlResult['value']);
}


// Set headers in the Excel sheet
foreach ($headers as $index => $header) {
    $column = chr(65 + $index); // A, B, C, ...
    $sheet->setCellValue($column . '1', $header);
}

// Initialize the row counter



// $attributeString = json_encode($attributeAr);
// $attributeString = str_replace(array('[', ']', '"'), '', $attributeString);
// $arr = explode(',', $attributeString);
// $attributeString = "'" . implode("', '", $arr) . "'";



$i = 2; // Start from row 2 for data
$serial_number = 1; // Initialize the serial number

while ($row = mysqli_fetch_assoc($sql_app)) {

    $id = $row['id'];
    $atmid = $row['atmid'];
    $isDelivered = $row['isDelivered'];
    $ifExistTrackingUpdate = $row['ifExistTrackingUpdate'];
    $vendorId = $row['vendorId'];
    $vendorName = getVendorName($vendorId);
    $address = $row['address'];
    $contactPerson = $row['contactPersonName'];
    $contactNumber = $row['contactPersonNumber'];
    $pod = $row['pod'];
    $courier = $row['courier'];
    $remark = $row['remark'];
    $date = $row['created_at'];

    $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . $atmid . "' and siteid='" . $siteid . "' order by id desc");
    if ($ifExistTrackingUpdateSqlResult = mysqli_fetch_assoc($ifExistTrackingUpdateSql)) {
        $ifExistTrackingUpdate = 1;
    } else {
        $ifExistTrackingUpdate = 0;
    }

    // Set the data in the Excel sheet
    $sheet->setCellValue('A' . $i, $serial_number);
    $sheet->setCellValue('B' . $i, $atmid);
    $sheet->setCellValue('C' . $i, ($isDelivered == 1 ? 'Delivered' : 'In-Transit'));
    $sheet->setCellValue('D' . $i, ($ifExistTrackingUpdate == 1 ? '-' : '-'));
    $sheet->setCellValue('E' . $i, $vendorName);
    $sheet->setCellValue('F' . $i, $address);
    $sheet->setCellValue('G' . $i, $contactPerson);
    $sheet->setCellValue('H' . $i, $contactNumber);
    $sheet->setCellValue('I' . $i, $pod);
    $sheet->setCellValue('J' . $i, $courier);
    $sheet->setCellValue('K' . $i, $remark);
    $sheet->setCellValue('L' . $i, $date);

    $attributeColumn = 'M';
    foreach ($attributeAr as $attributeArKey => $attributeArVal) {
        $detailsQuery = "SELECT COUNT(1) as total FROM material_send_details WHERE materialSendId = '".$id."' AND attribute LIKE '%" . mysqli_real_escape_string($con, $attributeArVal) . "%'";
        $detailsResult = mysqli_query($con, $detailsQuery);
    
        if ($detailsResult) {
            $detailsRow = mysqli_fetch_assoc($detailsResult);
            $count = $detailsRow['total'];
        } else {
            $count = 0;
        }
    
        $sheet->setCellValue($attributeColumn . $i, $count);
        $attributeColumn++;
    }
    
    $i++;
    $serial_number++;
}



// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventory.xlsx"');
header('Cache-Control: max-age=0');

// Create a writer to save the Excel file
$writer = new Xlsx($spreadsheet);

// Save the Excel file to a temporary location
$tempFile = tempnam(sys_get_temp_dir(), 'Inventory');
$writer->save($tempFile);

// Provide the file as a download to the user
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="SentMaterial.xlsx"');
header('Cache-Control: max-age=0');
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
