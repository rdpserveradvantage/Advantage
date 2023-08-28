<? include('config.php');

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
        $atmid = $rowData[$i][0][1] ;
        
        $networkIP = $rowData[$i][0][2] ;
        $routerIP = $rowData[$i][0][4] ;
        $atmIP =  $rowData[$i][0][6] ;
        $subnetIP = $rowData[$i][0][7] ;
        $sql = "update sites set networkIP='".$networkIP."' , routerIP='".$routerIP."',atmIP='".$atmIP."',subnetIP = '".$subnetIP."' where atmid='".$atmid."'" ;
        if(mysqli_query($con,$sql)){
            echo 'Details Added for ATMID : ' . $atmid ;
            echo '<br />';
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
                                    

