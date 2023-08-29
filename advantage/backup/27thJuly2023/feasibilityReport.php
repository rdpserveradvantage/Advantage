<?php include('header.php'); 

        $atmid = $_REQUEST['atmid'];
                                
?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Feasibility Report for ATMID : <span style="color:red;display: inline-block;"><? echo $atmid ; ?></span></h5>
                                </div>
                                <div class="card-block accordion-block">
                                    <div id="accordion" role="tablist" aria-multiselectable="true">
                                        <?php
                                        
                                        
                                        if(isset($_POST['rejectsubmit'])){
                                            $status = 'Reject';
                                            
                                            $feasibiltyId = $_REQUEST['feasibiltyId'];
                                            $atm_id = $_REQUEST['atmid'];
                                            $getsiteIdSql = mysqli_query($con,"select * from sites where atmid='".$atm_id."'");
                                            $getsiteIdSql_result = mysqli_fetch_assoc($getsiteIdSql);
                                            $siteid = $getsiteIdSql_result['id'];
                                            
                                            mysqli_query($con,"update sites set verificationStatus='".$status."' where id='".$siteid."'") ;
                                            mysqli_query($con,"update feasibilityCheck set verificationStatus='".$status."' where id='".$feasibiltyId."'") ;
                                            
                                            feasibilityApprovalReject($siteid,$atm_id,'') ; 
                                            
                                            
                                            
                                        }else if(isset($_POST['verifysubmit'])){
                                            $status = 'Verify';
                                            $feasibiltyId = $_REQUEST['feasibiltyId'];
                                            $atm_id = $_REQUEST['atmid'];
                                            $getsiteIdSql = mysqli_query($con,"select * from sites where atmid='".$atm_id."'");
                                            $getsiteIdSql_result = mysqli_fetch_assoc($getsiteIdSql);
                                            $siteid = $getsiteIdSql_result['id'];
                                            
                                            mysqli_query($con,"update sites set verificationStatus='".$status."' where id='".$siteid."'") ;
                                            mysqli_query($con,"update feasibilityCheck set verificationStatus='".$status."' where id='".$feasibiltyId."'") ;
                                            
                                            
                                            feasibilityApprovalVerify($siteid,$atm_id,'') ; 
                                            // Initiate Material Request here
                                            
                                            $materialQuantities = [];
                                            $sql = "SELECT value, count FROM boq";
                                            $result = $con->query($sql);
                                            
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $materialName = $row['value'];
                                                    $quantity = $row['count'];
                                                    $materialQuantities[$materialName] = $quantity;
                                                }
                                            }
                                            
                                            
                                            
                                            $feasSql = mysqli_query($con,"select * from feasibilityCheck where id='".$feasibiltyId."'");
                                            $feasSql_result = mysqli_fetch_assoc($feasSql);
                                            $isVendor = $feasSql_result['isVendor'] ; 
                                            
                                            if($isVendor==0){
                                                $type = 'Internal' ;
                                                $vendorId = 0 ; 
                                            }else if($isVendor == 1 ){
                                                $type = 'External' ;
                                                $feasibiltyCreatedBy = $feasSql_result['created_by'] ;
                                                
                                                $vendorsql = mysqli_query($con,"select * from vendorUsers where id='".$feasibiltyCreatedBy."'");
                                                $vendorsql_result = mysqli_fetch_assoc($vendorsql);
                                                $vendorId = $vendorsql_result['vendorId'];
                                                
                                            }
                                            
                                             
                                            
                                             
                                            
                                            // Generate material requests
                                            foreach ($materialQuantities as $materialName => $quantity) {
                                                // Insert the material request into the table
                                                $sql = "INSERT INTO material_requests (siteid, feasibility_id, material_name, quantity, status, created_by,created_at,type,vendorId)
                                                        VALUES ('$siteid', '$feasibiltyId', '$materialName', '$quantity', 'pending', '".$userid."','".$datetime."','".$type."',$vendorId)";
                                                if ($con->query($sql) === false) {
                                                    echo "Error: " . $sql . "<br>" . $con->error;
                                                }
                                            }

                                            generatesAutoMaterialRequest($siteid,$atm_id,'') ; 
                                            
                                            
                                            
                                            
                                            
                                            // End Material Request
                                            
                                            
                                            
                                        }
                                        
                                
                                        $query = "SELECT * FROM feasibilityCheck where ATMID1='".$atmid."'";

                                        $result = $con->query($query);

                                        if ($result->num_rows > 0) {
                                            $i=1 ; 
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id'];
                                                $isVendor = $row['isVendor'];
                                                $atm_id = $row['atmid'];
                                                $getverificationStatus = $row['verificationStatus'];
                                                
                                                if($isVendor){
                                                    $baseurl = 'http://103.216.208.241:8080/clarity/API/';
                                                }else{
                                                    $baseurl = 'http://103.216.208.241:8080/advantage/API/';
                                                }
                                                
                                                echo '<div class="accordion-panel">';
                                                
                                                echo '<div class="accordion-heading" role="tab" id="heading' . $i . '">';
                                                echo '<h3 class="card-title accordion-title">';
                                                echo '<a class="accordion-msg" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '">';
                                                echo 'Feasibility Check ' . $i;
                                                echo '</a>';
                                                echo '</h3>';
                                                echo '</div>';
                                                echo '<div id="collapse' . $i . '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading' . $i . '">';
                                                echo '<div class="accordion-content accordion-desc">';
                                                
                                                echo '<form action="' . $_SERVER['PHP_SELF'] . '?atmid=' . $atmid . '" method="POST">';
                                                
                                                echo '<table class="table">';
                                                foreach ($row as $column => $value) {
                                                    echo '<tr>';
                                                    echo '<th>' . formatColumnName($column) . '</th>';
                                                    if (substr($column, -4) === 'Snap' || substr($column, -5) === 'Snap2') {
                                                        echo '<td><a href="' . $baseurl.$value . '" target="_blank">View Image</a></td>';
                                                    } else {
                                                        echo '<td>' . $value . '</td>';
                                                    }
                                                    
                                                    echo '</tr>';
                                                }
                                                echo '</table>';

                                                if(isset($getverificationStatus) && !empty($getverificationStatus)){
                                                    if($getverificationStatus=='Reject'){
                                                        echo '<h4>Rejected !</h4>' ; 
                                                    }else if($getverificationStatus=='Verify'){
                                                        echo '<h4>Verified !</h4>' ; 
                                                    }
                                                }else{
                                                echo '<input type="hidden" name="atm_id" value="'.$atm_id.'" />';
                                                echo '<input type="hidden" name="feasibiltyId" value="'.$id.'" />';
                                                echo '<input type="submit" name="verifysubmit" value="Verify" class="btn btn-primary" onclick="return confirm(\'Are you sure you want to verify ?\');">';
                                                echo '<input type="submit" name="rejectsubmit" value="Reject" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to reject ?\');">';
                                                    
                                                }
                                                
                                                
                                                echo '</form>';
                                                
                                                
                                                echo '</div>';

                                                echo '</div>';
                                                


                                                echo '</div>';

                                                $i++ ; 
                                            }
                                        } else {
                                            echo "No records found.";
                                        }

                                        $con->close();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="files/assets/pages/accordion/accordion.js"></script>

<?php include('footer.php'); ?>

<?php
// Function to break down column name
function formatColumnName($columnName) {
    return implode(' ', preg_split('/(?=[A-Z])/', $columnName));
}
// Function to check if a URL-like value represents a valid image URL
function isValidImageUrl($url) {
    $url1 = 'https://sarmicrosystems.in/RailTailVendor/feasibiltyData/API/';
    $url2 = 'https://sarmicrosystems.in/advantages/feasibiltyData/API/';
    
    return (strpos($url, $url1) === 0 || strpos($url, $url2) === 0);
}

// Function to check if a URL-like value represents a valid image URL
// function isValidImageUrl($url) {
//     // Add your custom validation logic here
//     return filter_var($url, FILTER_VALIDATE_URL) !== false;
// }

?>
