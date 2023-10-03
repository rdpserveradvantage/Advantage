<? include('header.php'); ?>

<style> 
    .card-data{
        overflow-x: auto;
    }
        
</style>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        <div class="two_end">
                                        <h5>Delegate Bulk Sites </h5>
                                    <a class="btn btn-success" href="excelformat/bulkVendorDelegate.xlsx" download>BULK SITES DELEGATE FORMAT</a>
                                    
                                </div>
                                        
                        
                                
                                
                                    <form action="<? echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                                        <hr />
                                        <div class="form-group row">
                                            
                                            
                                            <div class="col-sm-4">
                                                <select class="form-control" name="vendor" required>
                                                    <option value="">-- Select Vendor --</option>
                                                    <?
                                                    $vendorsql = mysqli_query($con,"select * from vendor where status=1");
                                                    while($vendorsql_result = mysqli_fetch_assoc($vendorsql)){
                                                        $id = $vendorsql_result['id'];
                                                        $vendorName = $vendorsql_result['vendorName'];
                                                        ?>
                                                        <option value="<? echo $id ; ?>">
                                                            <? echo $vendorName ; ?>    
                                                        </option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="file" name="images" required>
                                            </div>
                                            
                                            
                                            
                                            <div class="col-sm-4">
                                                  <input type="submit" name="submit" value="Delegate" class="btn btn-danger">
                                            </div>
                                                
                                        </div>
                                    </form>
                                    
                                    
                                    </div>
                                </div>
                                
                                
                                        <? 
ini_set('memory_limit', '-1');

if(isset($_POST['submit'])){

?>                                
                                <div class="card">
                                    <div class="card-body">

<? 

$vendorid = $_REQUEST['vendor'];
$vendorName = getVendorName($vendorid);

$date = date('Y-m-d h:i:s a', time());
$only_date = date('Y-m-d');
$target_dir = 'PHPExcel/';
$file_name=$_FILES["images"]["name"];
$file_tmp=$_FILES["images"]["tmp_name"];
$file =  $target_dir.'/'.$file_name;
$created_at = date('Y-m-d H:i:s');

move_uploaded_file($file_tmp=$_FILES["images"]["tmp_name"],$target_dir.'/'.$file_name);
include('PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
$inputFileName = $file;

  try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
  } catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
        $e->getMessage());
  }

  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

  for ($row = 1; $row <= $highestRow; $row++) { 
    $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                    null, true, false);                            
  }

    $row = $row-2;
    $error = '0';
    $contents='';

    for($i = 1; $i<=$row; $i++){
        $activity = $rowData[$i][0][0] ;
        $customer = $rowData[$i][0][1] ; 
        $bank = $rowData[$i][0][2] ; 
        $atmid = $rowData[$i][0][3] ; 
        $atmid2 = $rowData[$i][0][4] ; 
        $atmid3 = $rowData[$i][0][5] ; 
        $address = $rowData[$i][0][6] ; 
        $city = $rowData[$i][0][7] ; 
        $state = $rowData[$i][0][8] ; 
        $zone = $rowData[$i][0][9] ; 
        $LHO = $rowData[$i][0][10] ; 
        $SBI_LHO_Contact_Person = $rowData[$i][0][11] ; 
        $SBI_LHO_Contact_Person_No = $rowData[$i][0][12] ; 
        $SBI_LHO_Contact_Person_email = $rowData[$i][0][13] ; 
        $LHO_Adv_Person = $rowData[$i][0][14] ; 
        $LHO_Adv_Contact = $rowData[$i][0][15] ; 
        $LHO_Adv_email = $rowData[$i][0][16] ; 
        $Project_Coordinator_Name = $rowData[$i][0][17] ; 
        $Project_Coordinator_No = $rowData[$i][0][18] ; 
        $Project_Coordinator_email = $rowData[$i][0][19] ; 
        $Customer_SLA = $rowData[$i][0][20] ; 
        $Our_SLA = $rowData[$i][0][21] ; 
        $Vendor = $rowData[$i][0][22] ; 
        $Cash_Management = $rowData[$i][0][23] ; 
        $CRA_VENDOR = $rowData[$i][0][24] ; 
        $ID_on_Make = $rowData[$i][0][25] ; 
        $Model = $rowData[$i][0][26] ; 
        $SiteType = $rowData[$i][0][27] ; 
        $PopulationGroup = $rowData[$i][0][28] ; 
        $XPNET_RemoteAddress = $rowData[$i][0][29] ; 
        $CONNECTIVITY = $rowData[$i][0][30] ; 
        $Connectivity_Type = $rowData[$i][0][31] ; 
        $Site_data_Received_for_Feasiblity_date = $rowData[$i][0][32] ; 

        $excelDate = $Site_data_Received_for_Feasiblity_date;
        $unixTimestamp = ($excelDate - 25569) * 86400;  // Convert to Unix timestamp
        $Site_data_Received_for_Feasiblity_date = date('Y-m-d', $unixTimestamp);
        
        


            if($activity){
                
                $check_sql = mysqli_query($con,"select id,atmid from sites where atmid='".$atmid."' and status=1");
                if($check_sql_result = mysqli_fetch_assoc($check_sql)){
                    $siteid = $check_sql_result['id'];
                    $atmid; 
                    $vendorid;
                    $vendorName;
                    
                    $delegateSql = "insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by) 
                        values('".$vendorid."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."')";
                    if(mysqli_query($con,$delegateSql)){
                        
                        $update = "update sites set isDelegated=1,deletedToVendorId='".$vendorid."',deletedToVendorName='".$vendorName."' where id='".$siteid."'" ; 
                        if(mysqli_query($con,$update)){
                            echo $atmid .' Deleted to ' . $vendorName .'<br />' ; 
                        }
                        
                    }   
                }
        }
    }
 ?>   
                                      </div>
                                </div>
 
<? } ?>

                             </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
