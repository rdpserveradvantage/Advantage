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
'Srno',
'ATMID',
'Material',
'Serial Number',
'Status',
'Contact Person',
'Contact Number',
'POD',
'Courier',
'Remark',
'Date',
'Dispatch'
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
    
                $id = $sql_result['id'];
                
                $detailSql = mysqli_query($con, "select * from material_send_details where materialSendId='" . $id . "'");
                $detailSqlResult = mysqli_fetch_assoc($detailSql);
                
                $materialName = $detailSqlResult['attribute'];
                $serialNumber = $detailSqlResult['serialNumber'];
                
                
                
                $siteid = $sql_result['siteid'];
                $atmid = $sql_result['atmid'];
                $isSingleProduct = (!$atmid) ? 1 : 0;
                
                $vendorId = $sql_result['vendorId'];
                $vendorName = getVendorName($vendorId);
                $address = $sql_result['address'];
                $contactPerson = $sql_result['contactPersonName'];
                $contactNumber = $sql_result['contactPersonNumber'];
                $pod = $sql_result['pod'];
                $courier = $sql_result['courier'];
                
                $remark = $sql_result['remark'];
                
                $date = $sql_result['created_at'];
                
                $isDelivered = $sql_result['isDelivered'];
                $againSend = mysqli_query($con, "select * from vendorMaterialSend where siteid='" . $siteid . "' and status=1");
                if ($againSendResult = mysqli_fetch_assoc($againSend)) {
                    $isAgainSendStatus = 1;
                    $contactPersonName = $againSendResult['contactPersonName'];
                    $contactPersonName = vendorUsersData($contactPersonName, 'name');
                } else {
                    $isAgainSendStatus = 0;
                }
                $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . $atmid . "' and siteid='" . $siteid . "' order by id desc");
                if ($ifExistTrackingUpdateSqlResult = mysqli_fetch_assoc($ifExistTrackingUpdateSql)) {
                    $ifExistTrackingUpdate = 1;
                } else {
                    $ifExistTrackingUpdate = 0;
                }
                
                 if ($isDelivered == 1 && $isAgainSendStatus == 0) {
                                            $deliveryStatus =  "Dispatch";
                                        } else if ($isDelivered == 1 && $isAgainSendStatus == 1) {
                                            $deliveryStatus = "Material Send to $contactPersonName " ;
                                        } else {
                                            $deliveryStatus = "No Status";
                                        }




    
     $sheet->getStyle('A' . $i . ':L' . $i)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'], // Border color (black)
            ],
        ],
    ]);
    
    
        $sheet->setCellValue('A' . $i , $serial_number ) ; 
        $sheet->setCellValue('B' . $i , $atmid ? $atmid : 'NA' ) ;  
        $sheet->setCellValue('C' . $i , $isSingleProduct == 1 ? $materialName : '-' ) ;  
        $sheet->setCellValue('D' . $i , $isSingleProduct == 1 ? $materialName : '-') ;  
        $sheet->setCellValue('E' . $i , $isDelivered == 1 ? 'Delivered' : 'In-Transit' ) ;  
        
        $sheet->setCellValue('F' . $i , $contactPerson ? $contactPerson : '-' ) ;  
        $sheet->setCellValue('G' . $i , $contactNumber ? $contactNumber : '-' ) ;  
        $sheet->setCellValue('H' . $i , $pod ? $pod : '-' ) ;  
        $sheet->setCellValue('I' . $i , $courier ? $courier : '-' ) ;  
        $sheet->setCellValue('J' . $i , $remark ? $remark : '-' ) ;  
        $sheet->setCellValue('K' . $i , $date ? $date : '-' ) ;    
        $sheet->setCellValue('L' . $i , $deliveryStatus ? $deliveryStatus : '-' ) ;
        
        
    $i++;
    $serial_number++;
    
    
}

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
header('Content-Disposition: attachment;filename="All Stocks.xlsx"');
header('Cache-Control: max-age=0');
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
?>
