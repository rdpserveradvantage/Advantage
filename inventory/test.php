<?php include('config.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello PhpSpreadsheet!');

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventory.xlsx"');
header('Cache-Control: max-age=0');

$exportSql = $_REQUEST['exportSql'] ; 
$sql_app = mysqli_query($con,$exportSql);

$headers = array(
    'Sr_no' => 'A1',
    'material' => 'B1',
    'material_make' => 'C1',
    'model_no' => 'D1',
    'serial_no' => 'E1',
    'challan_no' => 'F1',
    'amount' => 'G1',
    'gst' => 'H1',
    'amount_with_gst' => 'I1',
    'courier_detail' => 'J1',
    'tracking_details' => 'K1',
    'date_of_receiving' => 'L1',
    'receiver_name' => 'M1',
    'vendor_name' => 'N1',
    'vendor_contact' => 'O1',
    'po_date' => 'P1',
    'po_number' => 'Q1',
    'Type' => 'R1',
);



$i = 1;
while ($row = mysqli_fetch_assoc($sql_app)) {
    $material = $row['material'];
    $material_make = $row['material_make'];
    $model_no = $row['model_no'];
    $serial_no = $row['serial_no'];
    $challan_no = $row['challan_no'];
    $amount = $row['amount'];
    $gst = $row['gst'];
    $amount_witd_gst = $row['amount_witd_gst'];
    $courier_detail = $row['courier_detail'];
    $tracking_details = $row['tracking_details'];
    $date_of_receiving = $row['date_of_receiving'];
    $receiver_name = $row['receiver_name'];
    $vendor_name = $row['vendor_name'];
    $vendor_contact = $row['vendor_contact'];
    $po_date = $row['po_date'];
    $po_number = $row['po_number'];
    $inventoryType = $row['inventoryType'];



    $record = array(
        'Sr_no' =>  $i,
        'material' =>  $material,
        'material_make' =>  $material_make,
        'model_no' =>  $model_no,
        'serial_no' =>  $serial_no,
        'challan_no' =>  $challan_no,
        'amount' =>  $amount,
        'gst' =>  $gst,
        'amount_with_gst' =>  $amount_witd_gst,
        'courier_detail' =>  $courier_detail,
        'tracking_details' =>  $tracking_details,
        'date_of_receiving' =>  $date_of_receiving,
        'receiver_name' =>  $receiver_name,
        'vendor_name' =>  $vendor_name,
        'vendor_contact' =>  $vendor_contact,
        'po_date' =>  $po_date,
        'po_number' =>  $po_number,
        'Type' =>  $inventoryType
    );

    $i++;
}



$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
