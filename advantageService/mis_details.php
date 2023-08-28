<?php include('header.php');  ?>


  
<link rel="stylesheet" type="text/css" href="./datatable/dataTables.bootstrap.css">
    <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <h5>SITE INFORMATION</h5>
                                        <hr>
                                        
                                        <?
                                        $id = $_GET['id'];
                                        $sql = mysqli_query($con,"select * from mis_details  where id= '".$id."'");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        
                                        $mis_id = $sql_result['mis_id']; 
                                        
                                        
                                        $atmid = $sql_result['atmid'];
                                        $date = date('Y-m-d');

                                        
                                        $ide = $sql_result['id'];
                                        $detail_history = mysqli_query($con,"select * from mis_history  where mis_id = '".$ide."' ");
                                        $fetch_detail_history = mysqli_fetch_assoc($detail_history);
                                        
                                        // $address_history = $fetch_detail_history['delivery_address'];
                                        // $mobile = $fetch_detail_history['contact_person_mob'];
                                        // $name = $fetch_detail_history['contact_person_name'];
                                        // echo "<script> alert($name); </script>";
                                        
                                        $sql1 = mysqli_query($con,"select * from mis where id = '".$mis_id."'");
                                        $sql1_result = mysqli_fetch_assoc($sql1);
                                        $branch = $sql1_result['branch'];
                                        
                                        
                                        ?>
                                        <div class="view-info">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="general-info">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-6">
                                                                <div class="table-responsive">
                                                                    <table class="table m-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Ticket ID </th>
                                                                                <td><? echo $sql_result['ticket_id'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">ATM ID</th>
                                                                                <td>
                                                                                    <span><? echo $sql_result['atmid'];?></span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Bank</th>
                                                                                <td><? echo $sql1_result['bank'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Location</th>
                                                                                <td><? echo $sql1_result['location'];?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- end of table col-lg-6 -->
                                                            <div class="col-lg-12 col-xl-6">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <tr>
                                                                                <th scope="row">City</th>
                                                                                <td><? echo $sql1_result['city'];?></td>
                                                                            </tr>
                                                                            
                                                                                <th scope="row">State</th>
                                                                                <td><? echo $sql1_result['state'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Zone</th>
                                                                                <td><? echo $sql1_result['zone'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Status</th>
                                                                                <td><? echo $sql_result['status'];?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- end of table col-lg-6 -->
                                                        </div>
                                                        <!-- end of row -->
                                                    </div>
                                                    <!-- end of general info -->
                                                </div>
                                                <!-- end of col-lg-12 -->
                                            </div>
                                            
                                            <!-- end of row -->
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                                                <div class="card">
                                    <div class="card-block">

                                        <h5>CALL INFORMATION</h5>
                                        <hr>                                        
                                        <?
                                        $id = $_GET['id'];
                                        $sql = mysqli_query($con,"select * from mis_details  where id= '".$id."'");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        
                                        $mis_id = $sql_result['mis_id']; 
                                        
                                        $mis_status = $sql_result['status'];
                                        $status_view = 0;
                                         if($mis_status=='material_in_process'){
                                             $status_view = 1;
                                         }
                                        
                                        $sql1 = mysqli_query($con,"select * from mis where id = '".$mis_id."'");
                                        $sql1_result = mysqli_fetch_assoc($sql1);
                                        
                                        $date = date('Y-m-d H:i:s');
                                        $date1 = date('Y-m-d');
                                        $date1=date_create($date1);
                                        $date2=date_create($sql_result['created_at']);
                                        $diff=date_diff($date1,$date2);
        
        
                                        ?>
                                        <div class="view-info">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="general-info">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-6">
                                                                <div class="table-responsive">
                                                                    <table class="table m-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Ticket ID </th>
                                                                                <td><? echo $sql_result['ticket_id'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Assigned Engineer</th>
                                                                                <td><? ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Current Status</th>
                                                                                <td><? echo $sql_result['status'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Component</th>
                                                                                <td><? echo $sql_result['component'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Sub Component</th>
                                                                                <td><? echo $sql_result['subcomponent'];?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- end of table col-lg-6 -->
                                                            <div class="col-lg-12 col-xl-6">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Created On</th>
                                                                                <td>
                                                                                    <span><? echo $sql_result['created_at'];?></span>
                                                                                </td>
                                                                            </tr>
                                                                            
                                                                                <th scope="row">Created By</th>
                                                                                <td><? echo $sql1_result['serviceExecutive'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Down Time </th>
                                                                                <td><? echo $diff->format("%a days");?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Remark</th>
                                                                                <td><? echo $sql1_result['remarks']; ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- end of table col-lg-6 -->
                                                        </div>
                                                        <!-- end of row -->
                                                    </div>
                                                    <!-- end of general info -->
                                                </div>
                                                <!-- end of col-lg-12 -->
                                            </div>
                                            <!-- end of row -->
                                        </div>
                                                                
                                                                
                                    </div>
                                </div>
                                
                               
                               
                                                               
                                <div class="card">
                                    <div class="card-block">
                                        <h5>Change Status</h5>
                                                                                <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <select class="form-control" name="status" id="status">
                                                    
                                                    <?php if($mis_status == 'open' || $mis_status == 'Open') {?>
                                                        <option value="">Select</option>
                                                        <!-- <option value="schedule"> Schedule</option>    
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="permission_require">Permission Required</option>
                                                        <option value="MRS">Material Pending</option> -->
                                                        <option value="close">close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'schedule') {?>
                                                        <option value="">Select</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="permission_require">Permission Required</option>
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="close">close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'material_requirement') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>
                                                        <option value="material_dispatch">Material Dispatch</option>
                                                        <option value="material_in_process">Material in Process</option>
                                                        <option value="close">close</option>
                                                    <?php }
                                                    
                                                   
                                                    
                                                    if($mis_status == 'fund_required') {?>
                                                        <option value="">Select</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="schedule">Schedule</option>
                                                        <option value="close">close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'material_dispatch') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>    
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="permission_require">Permission Required</option>     
                                                        <option value="close">close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'close') {?>
                                                        <option value="">Select</option>
                                                        <option value="reopen">Reopen</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'permission_require') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>    
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="material_requirement">Material Requirement</option> 
                                                        <option value="close">close</option>
                                                    <?php } 
                                                   
                                                    if($mis_status == 'available') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>    
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="material_dispatch">Material Dispatch</option> 
                                                        <option value="permission_require">Permission Required</option>     
                                                        <option value="close">close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'cancelled') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="close">close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'MRS') {?>
                                                        <option value="">Select</option>
                                                        <option value="material_dispatch">Material Dispatch</option> 
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="material_requirement">Material Requirement</option> 
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="close">close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'material_in_process') {?>
                                                        <option value="">Select</option>
                                                        <option value="close">Close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'material_delivered') {?>
                                                        <option value="">Select</option>
                                                        <option value="close">Close</option>
                                                    <?php } 
                                                    ?>
                                                </select> 
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        
                                        
                                        
                                        
                                        <?
                                        
                                        if(isset($_POST['status'])){

                                            
                                            if($_POST['status']=='close'){
                                                $status = $_POST['status'] ;
                                                $year = date('Y');
                                                $month = date('m');
                                                $target_dir = 'close_uploads/'.$year .'/'. $month.'/'. $atmid ;
                                                $link = "";
                                                $link2 = "";
                                                
                                                $engineer = $_POST['engineer'];
                                                $remark = $_POST['remark'];
                                                $oldMaterialDetails = $_POST['oldMaterialDetails'];
                                                $statement = "insert into mis_history (mis_id,type,attachment,attachment2,remark,status,created_at,created_by) values('".$id."','".$status."','".$link."','".$link2."','".$remark."','1','".$date."','".$userid."')" ;
                                                mysqli_query($con,"update mis_details set close_date = '".$date."' where id = '".$id."'");
                                            }
                                            
                                            
                                            if(mysqli_query($con,$statement)){
                                                if($status == 'reopen'){
                                                    $status = 'open';
                                                } else {
                                                    $status = $_POST['status'];
                                                }
                                            mysqli_query($con,"update mis_details  set status = '".$status."' where id = '".$id."'");
                                            
                                            ?>
                                                
                                            <script>
                                                swal("Great !", "Call Updated Successfully !", "success");
                                                
                                                    setTimeout(function(){ 
                                                        window.location.href="mis_details.php?id=<? echo $id ; ?>";
                                                        // window.location.reload();
                                                    }, 2000);

                                            </script>
                                            <? }else{ 
                                            
                                            echo mysqli_error($con);
                                            ?>
                                               
                                            <script>
                                                swal("Oops !", "Call Updated Error !", "error");
                                                
                                                    setTimeout(function(){ 
                                                        // window.location.href="mis_details.php?id=<? echo $id ; ?>";
                                                    }, 2000);

                                            </script>
                                            
                                            <? } }
                                        
                                        ?>
                                        
                                <form action="<? echo $_SERVER['PHP_SELF'];?>?id=<? echo $id ;?>" method="POST" enctype="multipart/form-data">
                                        <div class="row" id="status_col"></div>
                                </form>
                                        
                                        
                                    </div>
                                </div>
                                
                                 
                                
                                
                                <div class="card">
                                    <div class="card-block" style="overflow:scroll;">
                                        <h5>CALL DISPATCH INFORMATION</h5>

                                        <hr>
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>Sn No</th>
                                                    <th>Status</th>
                                                    <th>Remarks</th>
                                                    <th>Date</th>
                                                    <th>Schedule Date</th>
                                                    <th>Require Material Name </th>
                                                    <th>Engineer</th>
                                                    <th>POD</th>
                                                    <th>Action By</th>
                                                    <th>Attchement</th>
                                                    <th>Attchement 2</th>
                                                    <th>Material Delivered Date</th>
                                                    <th>Address (Material Requirement)</th>
                                                    <th>Serial Number</th>
                                                    <th>Contact Person Name</th>
                                                    <th>Contact Person Mobile</th>
                                                </tr>

                                            </thead>
                                            <tbody> 
                                                <?
                                                // echo "select * from mis_history  where mis_id ='".$id."'"; 
                                                
                                                $his_sql = mysqli_query($con,"select * from mis_history  where mis_id ='".$id."'");
                                                $i = 1 ; 
                                                while($his_sql_result = mysqli_fetch_assoc($his_sql)){ 
                                                    $is_material_dept = $his_sql_result['is_material_dept'];
                                                    ?>
                                                    <tr <? if($is_material_dept==1){ ?>  style="background-color: #404e67;color:white;"<? }?>>
                                                        <td><? echo $i ; ?></td>
                                                        <td><? echo $his_sql_result['type'];  ?></td>
                                                        <td><? echo $his_sql_result['remark'];  ?></td>
                                                        <td><? echo $his_sql_result['created_at'];  ?></td>
                                                        <td><? if($his_sql_result['schedule_date']!='0000-00-00'){ echo $his_sql_result['schedule_date']; }  ?></td>
                                                        <td><? echo $his_sql_result['material'];  ?></td>
                                                        <td><? echo getUsername($his_sql_result['engineer'],true);  ?></td>
                                                        <td><? echo $his_sql_result['pod'];  ?></td>
                                                        <td><? echo getUsername($his_sql_result['created_by'],true);  ?></td>
                                                        <td> <? if($his_sql_result['attachment']){ ?><a href="<? echo $his_sql_result['attachment'];  ?>" target="_blank">View Attchment</a> <? } ?></td>
                                                        <td> <? if($his_sql_result['attachment2']){ ?><a href="<? echo $his_sql_result['attachment2'];  ?>" target="_blank">View Attchment</a> <? } ?></td>
                                                        
                                                        <td><? if($his_sql_result['delivery_date']!='0000-00-00'){ echo $his_sql_result['delivery_date']; }  ?></td>
                                                        <td><? echo $his_sql_result['delivery_address'];  ?></td>
                                                        <td><? echo $his_sql_result['serial_number'];  ?></td>
                                                        
                                                        
                                                        <td><? echo $his_sql_result['contact_person_name'];  ?></td>
                                                        <td><? echo $his_sql_result['contact_person_mob'];  ?></td>
                                                        
                                                    </tr>
                                                <? $i++ ; } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>     
                                
                            </div>
                        </div>

 
                    </div>
                </div>
            </div>
                    
            <script>

$(document).on('change','#status',function(){
    
    var status = $(this).val();
    $("#status_col").html('');
    

         if(status == 'close'){
            var html = `<input type="hidden" name="status" value="close">
            <div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div>
            
            <div class="col-sm-12 oldMaterialDetails" style="display:none;">
            <br />
                <label>Old Material Details</label>
                <select name="oldMaterialDetails" id="oldMaterialDetails" class="form-control">
                  <option>-- Select --</option>
                  <option value="Old Material with Engineer">Old Material with Engineer</option>
                  <option value="Old Material Missing">Old Material Missing</option>
                  <option value="Old Material Scrap">Old Material Scrap</option>
                  <option value="Old Material in Service Center">Old Material in Service Center</option>
                  <option value="Old Material in Branch Office">Old Material in Branch Office</option>
                  <option value="Old Material in Dispached to Mumbai">Old Material in Dispached to Mumbai</option>
                </select>  
                </div>

            <div class="col-sm-12"><br><br><input class="btn btn-primary" value="Close" type="submit" name="submit"></div>` ;
        }
        
        $("#status_col").html(html);
});



function throttle(f, delay){
        var timer = null;
        return function(){
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = window.setTimeout(function(){
                f.apply(context, args);
            },
            delay || 1000);
        };
    }
    

    $(document).ready(function(){
        $(".js-example-basic-single").select2();
    });
     
    // $("#address_type").on("change",function(){ debugger; 
    function setaddress(){ 
        var address_type = $('#address_type').val();
        if(address_type=='Branch'){
            $('#address').val('Branch');
            $('#address').attr('readonly',true);
            $('#Contactperson_name').hide();
            $('#Contactperson_mob').hide();
             $('#Contactperson_name_text').attr('required',false);
            $('#Contactperson_mob_text').attr('required',false);
            $('#address').show();
        }
        if(address_type=='Other'){
            $('#address').val('');
            $('#address').attr('readonly',false);
             $('#Contactperson_name').show();
             $('#Contactperson_mob').show();
               $('#Contactperson_name_text').attr('required',true);
            $('#Contactperson_mob_text').attr('required',true);
            //  $('#address').show();
        }
    }




$(document).on('keyup','#address',throttle(function(){
   $("#item_name").html('');
   add = $(this).val();
          $.ajax({
            type: "POST",
            url: 'suggested_address.php',
            data: 'address=' + add,
            success:function(msg) {
             
             $("#item_name").append(msg);
             
                
            }
          });
//   alert(add);
}));



            </script>





<script src="./datatable/jquery.dataTables.js"></script>
<script src="./datatable/dataTables.bootstrap.js"></script>
<script src="./datatable/dataTables.buttons.min.js"></script>
<script src="./datatable/buttons.flash.min.js"></script>
<script src="./datatable/jszip.min.js"></script>

<script src="./datatable/pdfmake.min.js"></script>
<script src="./datatable/vfs_fonts.js"></script>
<script src="./datatable/buttons.html5.min.js"></script>
<script src="./datatable/buttons.print.min.js"></script>
<script src="./datatable/jquery-datatable.js"></script>

    <? include('footer.php'); ?>
