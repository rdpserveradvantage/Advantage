<?php include('config.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();



$exportSql = $_REQUEST['exportSql']; 
$sql_app = mysqli_query($con, $exportSql); 

$headerStyles = [
    'font' => [
        'bold' => true, // Make the text bold
        'color' => ['rgb' => 'FFFFFF'], // Font color (white)
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '0070C0'], // Background color (blue)
    ],
    'borders' => [
        'outline' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'], // Border color (black)
        ],
    ],
];


// Define column headers
$headers = array(
    'Sr no',
    'Actions',
    'material',
    'material_make',
    'model_no',
    'serial_no',
    'challan_no',
    'courier_detail',
    'tracking_details',
    'date_of_receiving',
    'receiver_name',
);


// Set headers in the Excel sheet with styles
foreach ($headers as $index => $header) {
    $column = chr(65 + $index); // A, B, C, ...
    $sheet->setCellValue($column . '1', $header);
    $sheet->getStyle($column . '1')->applyFromArray($headerStyles); // Apply styles to the header cell
    $sheet->getColumnDimension($column)->setAutoSize(true); // Auto-fill column width
}


// Initialize the row counter
$i = 2; // Start from row 2 for data
$serial_number = 1; // Initialize the serial number

while ($sql_result = mysqli_fetch_assoc($sql_app)) {
    
    $materialId = $sql_result['id'];
    $material = $sql_result['material'];
    $material_make = $sql_result['material_make'];
    $model_no = $sql_result['model_no'];
    $serial_no = $sql_result['serial_no'];
    $challan_no = $sql_result['challan_no'];
    $amount = $sql_result['amount'];
    $gst = $sql_result['gst'];
    $amount_witd_gst = $sql_result['amount_witd_gst'];
    $courier_detail = $sql_result['courier_detail'];
    $tracking_details = $sql_result['tracking_details'];
    $date_of_receiving = $sql_result['date_of_receiving'];
    $receiver_name = $sql_result['receiver_name'];
    $vendor_name = $sql_result['vendor_name'];
    $vendor_contact = $sql_result['vendor_contact'];
    $po_date = $sql_result['po_date'];
    $po_number = $sql_result['po_number'];
    $invstatus = $sql_result['status'];



    $vendormaterialsendDetailsSql = mysqli_query($con,"select * from vendormaterialsenddetails where serialNumber='".$serial_no."'");
    $vendormaterialsendDetailsSqlResult = mysqli_fetch_assoc($vendormaterialsendDetailsSql); 
    $vendormaterialsendDetailsSqlID = $vendormaterialsendDetailsSqlResult['materialSendId'];

    $vendormaterialsendSql = mysqli_query($con,"select * from vendormaterialsend where id='".$vendormaterialsendDetailsSqlID."'");
    $vendormaterialsendSqlResult = mysqli_fetch_assoc($vendormaterialsendSql);

    $contactPersonName = $vendormaterialsendSqlResult['contactPersonName'];
    $contactPersonName = vendorUsersData($contactPersonName, 'name');






    




    
     $sheet->getStyle('A' . $i . ':L' . $i)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'], // Border color (black)
            ],
        ],
    ]);
    
    
        $sheet->setCellValue('A' . $i , $serial_number ) ; 
        $sheet->setCellValue('B' . $i , $contactPersonName ? $contactPersonName : 'NA' ) ;  
        $sheet->setCellValue('C' . $i , $material ? $material : 'NA' ) ;  
        $sheet->setCellValue('D' . $i , $material_make ? $material_make : '-') ;  
        $sheet->setCellValue('E' . $i , $model_no ? $model_no : 'NA' ) ;  
        
        $sheet->setCellValue('F' . $i , $serial_no ? $serial_no : 'NA' ) ;  
        $sheet->setCellValue('G' . $i , $challan_no ? $challan_no : '-' ) ;  
        $sheet->setCellValue('H' . $i , $courier_detail ? $courier_detail : '-' ) ;  
        $sheet->setCellValue('I' . $i , $tracking_details ? $tracking_details : '-' ) ;  
        $sheet->setCellValue('J' . $i , $date_of_receiving ? $date_of_receiving : '-' ) ;  
        $sheet->setCellValue('K' . $i , $receiver_name ? $receiver_name : '-' ) ; 
        
    $i++;
    $serial_number++;
    
    
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Vendor-Inventory.xlsx"');
header('Cache-Control: max-age=0');

// Create a writer to save the Excel file
$writer = new Xlsx($spreadsheet);

// Save the Excel file to a temporary location
$tempFile = tempnam(sys_get_temp_dir(), 'Inventory');
$writer->save($tempFile);

// Provide the file as a download to the user
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="All Stocks.xlsx"');
header('Cache-Control: max-age=0');
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
?>
