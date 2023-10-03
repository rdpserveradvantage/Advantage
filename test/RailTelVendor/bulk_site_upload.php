<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<style>
    .card-data{
        overflow-x: auto;
    }
        
</style>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                                                        <div class="two_end">
                                    <h5>Update Bulk Sites <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="excelformat/bulk_site_excel.xlsx" download>BULK SITES UPLOAD FORMAT</a>
                                    
                                </div>
                                        
<? 
ini_set('memory_limit', '-1');

if(isset($_POST['submit'])){

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
                
                $check_sql = mysqli_query($con,"select atmid from sites where atmid='".$atmid."' and status=1");
                if($check_sql_result = mysqli_fetch_assoc($check_sql)){
                    
                    echo 'ATMID ' . $atmid . ' Already Exists ! ' ; 
                    
                }else{
                
                    $sql = "insert into sites(activity,customer,bank,atmid,atmid2,atmid3,address,city,state,zone,LHO,LHO_Contact_Person,LHO_Contact_Person_No,
                    LHO_Contact_Person_email,LHO_Adv_Person,LHO_Adv_Contact,LHO_Adv_email,Project_Coordinator_Name,Project_Coordinator_No,Project_Coordinator_email,
                    Customer_SLA,Our_SLA,Vendor,Cash_Management,CRA_VENDOR,ID_on_Make,Model,SiteType,PopulationGroup,XPNET_RemoteAddress,CONNECTIVITY,Connectivity_Type,
                    Site_data_Received_for_Feasiblity_date,status,created_at) values('".$activity."','".$customer."','".$bank."','".$atmid."','".$atmid2."','".$atmid3."',
                    '".$address."','".$city."','".$state."','".$zone."','".$LHO."','".$LHO_Contact_Person."','".$LHO_Contact_Person_No."','".$LHO_Contact_Person_email."',
                    '".$LHO_Adv_Person."','".$LHO_Adv_Contact."','".$LHO_Adv_email."','".$Project_Coordinator_Name."','".$Project_Coordinator_No."','".$Project_Coordinator_email."',
                    '".$Customer_SLA."','".$Our_SLA."','".$Vendor."','".$Cash_Management."','".$CRA_VENDOR."','".$ID_on_Make."','".$Model."','".$SiteType."','".$PopulationGroup."',
                    '".$XPNET_RemoteAddress."','".$CONNECTIVITY."','".$Connectivity_Type."','".$Site_data_Received_for_Feasiblity_date."',1,'".$datetime."')";
                    
                    
                    mysqli_query($con,$sql);
                    echo  'ATMID ' . $atmid  . ' Added ! ' ;
                    echo '<br>';
                    
            }
        }
    }
}
?>
                        
                                
                                
                                    <form action="<? echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            
                                            <div class="col-sm-4">
                                                <input type="file" name="images" class="form-control" required>
                                            </div>
                                            <div class="col-sm-4">
                                                  <input type="submit" name="submit" value="upload" class="btn btn-danger">
                                            </div>
                                                
                                        </div>
                                    </form>
                                    
                                    
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>
    
    
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">


<script>
$("#delete_err").on('click',function(){
if (confirm('Are you sure to delete all Records ?')) {
     $.ajax({

                type: "POST",
                url: 'delete_err_ajax.php',
                success:function(msg) {
                    if(msg==1){
                           $("#err_card").load(location.href+" #err_card>*","");                        
                    }
                }
            });
} else {
    alert('Canceled');
}





});


$(document).ready(function() {


    $('#data_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
           'copy',
            'excel',
            'csv',
            'pdf',
           ]
    } );
    
    $('#data_table2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
           'copy',
            'excel',
            'csv',
            'pdf',
           ]
    } );
    
} );

</script>



</body>

</html>