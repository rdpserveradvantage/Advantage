<?php include('header.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>

<style>
    .border-checkbox-section .border-checkbox-group .border-checkbox-label{
    width: 50%;
}
</style>

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
                            $sql = mysqli_query($con, "select * from mis_details  where id= '" . $id . "'");
                            $sql_result = mysqli_fetch_assoc($sql);

                            $mis_id = $sql_result['mis_id'];


                            $atmid = $sql_result['atmid'];
                            $date = date('Y-m-d');


                            $ide = $sql_result['id'];
                            $detail_history = mysqli_query($con, "select * from mis_history  where mis_id = '" . $ide . "' ");
                            $fetch_detail_history = mysqli_fetch_assoc($detail_history);

                            // $address_history = $fetch_detail_history['delivery_address'];
                            // $mobile = $fetch_detail_history['contact_person_mob'];
                            // $name = $fetch_detail_history['contact_person_name'];
                            // echo "<script> alert($name); </script>";

                            $sql1 = mysqli_query($con, "select * from mis where id = '" . $mis_id . "'");
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
                                                                    <td><? echo $sql_result['ticket_id']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">ATM ID</th>
                                                                    <td>
                                                                        <span><? echo $sql_result['atmid']; ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Bank</th>
                                                                    <td><? echo $sql1_result['bank']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Location</th>
                                                                    <td><? echo $sql1_result['location']; ?></td>
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
                                                                    <td><? echo $sql1_result['city']; ?></td>
                                                                </tr>

                                                                <th scope="row">State</th>
                                                                <td><? echo $sql1_result['state']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Zone</th>
                                                                    <td><? echo $sql1_result['zone']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Status</th>
                                                                    <td><? echo $sql_result['status']; ?></td>
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
                            $sql = mysqli_query($con, "select * from mis_details  where id= '" . $id . "'");
                            $sql_result = mysqli_fetch_assoc($sql);

                            $mis_id = $sql_result['mis_id'];

                            $mis_status = $sql_result['status'];
                            $status_view = 0;
                            if ($mis_status == 'material_in_process') {
                                $status_view = 1;
                            }

                            $sql1 = mysqli_query($con, "select * from mis where id = '" . $mis_id . "'");
                            $sql1_result = mysqli_fetch_assoc($sql1);

                            $date = date('Y-m-d H:i:s');
                            $date1 = date('Y-m-d');
                            $date1 = date_create($date1);
                            $date2 = date_create($sql_result['created_at']);
                            $diff = date_diff($date1, $date2);


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
                                                                    <td><? echo $sql_result['ticket_id']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Assigned Engineer</th>
                                                                    <td><? ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Current Status</th>
                                                                    <td><? echo $sql_result['status']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Component</th>
                                                                    <td><? echo $sql_result['component']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Sub Component</th>
                                                                    <td><? echo $sql_result['subcomponent']; ?></td>
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
                                                                        <span><? echo $sql_result['created_at']; ?></span>
                                                                    </td>
                                                                </tr>

                                                                <th scope="row">Created By</th>
                                                                <td><? echo $sql1_result['serviceExecutive']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Down Time </th>
                                                                    <td><? echo $diff->format("%a days"); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Remark</th>
                                                                    <td><? echo $sql1_result['remarks']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Hardware</th>
                                                                    <td><? echo $sql1_result['noProblemOccurs']; ?></td>
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

                                        <?php if ($mis_status == 'open' || $mis_status == 'Open') { ?>
                                            <option value="">Select</option>
                                            <option value="reassign"> Re-assign </option>
                                            <option value="material_requirement">Material Requirement</option>
                                            <option value="close">Close</option>
                                        <?php }

                                        if ($mis_status == 'material_requirement') { ?>
                                            <option value="">Select</option>
                                            <option value="schedule">Schedule</option>
                                            <option value="material_dispatch">Material Dispatch</option>
                                            <option value="material_in_process">Material in Process</option>
                                            <option value="close">Close</option>
                                        <?php } ?>



                                    </select>
                                </div>
                            </div>

                            <hr>





                            <?

                            if (isset($_POST['status'])) {

                                $status = $_POST['status'];
                                if ($status == 'close') {

                                    $year = date('Y');
                                    $month = date('m');
                                    $target_dir = 'mis_images/close_uploads/' . $year . '/' . $month . '/' . $atmid;
                                    $link = "";

                                    if (!file_exists($target_dir)) {
                                        mkdir($target_dir, 0777, true); // Set appropriate permissions (modify as needed)
                                    }

                                    $image = $_FILES['image']['name'];
                                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . '/' . $image)) {
                                        $link  = $target_dir . '/' . $image;
                                    }

                                    $engineer = $_POST['engineer'];
                                    $remark = $_POST['remark'];
                                    $oldMaterialDetails = $_POST['oldMaterialDetails'];
                                    $statement = "insert into mis_history (mis_id,type,attachment,remark,status,created_at,created_by) 
                                                values('" . $id . "','" . $status . "','" . $link . "','" . $remark . "','1','" . $date . "','" . $userid . "')";

                                    mysqli_query($con, "update mis_details set close_date = '" . $date . "' where id = '" . $id . "'");
                                    mysqli_query($con, "update mis set status = '" . $status . "' where id = '" . $mis_id . "'");
                                } else if ($status == 'material_requirement') {
                                    $remark = $_POST['remark'];
                                    $requiredMaterials = $_REQUEST['requiredMaterial'];
                                    $requiredMaterial = implode(', ', $requiredMaterials);

                                    $material_condition = $_REQUEST['material_condition'];
                                    $material_conditionStr = implode(',', $material_condition);

                                    $totalMaterialCount = count($material_condition);





                                    $year = date('Y');
                                    $month = date('m');
                                    $targetDir = 'materialRequirement/' . $year . '/' . $month . '/' . $atmid;
                                    $link = "";

                                    if (!file_exists($targetDir)) {
                                        mkdir($targetDir, 0777, true); // Set appropriate permissions (modify as needed)
                                    }





                                    for ($i = 0; $i < count($requiredMaterials); $i++) {
                                        $imageFileName = uniqid() . "_" . $_FILES['material_requirement_images']['name'][$i];
                                        $imagePath = $targetDir . '/' . $imageFileName;

                                        move_uploaded_file($_FILES['material_requirement_images']['tmp_name'][$i], $imagePath);

                                        $sql = "INSERT INTO mis_materialrequirement (mis_id, materialName, materialImage, materialCondition, status, created_at, created_by, portal)
                                                            VALUES ('$id', '$requiredMaterials[$i]', '$imagePath', '$material_condition[$i]', '1', '$datetime', '$userid', 'Service')";

                                        if (mysqli_query($con, $sql)) {
                                        } else {
                                            echo "Error: " . $sql . "<br>" . mysqli_error($con);
                                        }
                                    }






                                    mysqli_query($con, "update mis set status='material_requirement' WHERE id = $id");

                                    $statement = "insert into mis_history (mis_id,type,material,material_condition,remark,status,created_at,created_by,dependency) 
                                                values('" . $id . "','" . $status . "','" . $requiredMaterial . "','" . $material_conditionStr . "','" . $remark . "','1','" . $date . "','" . $userid . "','Advantage')";
                                } else if ($status == 'reassign') {

                                    $remark = $_REQUEST['remark'];
                                    mysqli_query($con, "update mis set status='reassign' WHERE id = $id");



                                    $ProblemOccurs = $_REQUEST['noProblemOccurs'];
                                    $ProblemOccursStr = implode(',', $ProblemOccurs);
                                    $year = date('Y');
                                    $month = date('m');
                                    $target_dir = 'reassign_uploads/' . $year . '/' . $month . '/' . $atmid;
                                    $link = "";

                                    if (!file_exists($target_dir)) {
                                        mkdir($target_dir, 0777, true); // Set appropriate permissions (modify as needed)
                                    }


                                    $image = $_FILES['image']['name'];
                                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . '/' . $image)) {
                                        $link  = $target_dir . '/' . $image;
                                    }

                                    $statement = "insert into mis_history (mis_id,type,attachment,remark,status,created_at,created_by,dependency,ProblemOccurs) 
                                                values('" . $id . "','" . $status . "','" . $link . "','" . $remark . "','1','" . $date . "','" . $userid . "','Bank','" . $ProblemOccursStr . "')";
                                }


                                if (mysqli_query($con, $statement)) {
                                    if ($status == 'reopen') {
                                        $status = 'open';
                                    } else {
                                        $status = $_POST['status'];
                                    }

                                    mysqli_query($con, "update mis_details  set status = '" . $status . "' where id = '" . $id . "'");

                            ?>

                                    <script>
                                        swal("Great !", "Call Updated Successfully !", "success");

                                        // setTimeout(function(){ 
                                        // window.location.href="mis_details.php?id=<? echo $id; ?>";
                                        // window.location.reload();
                                        // }, 2000);
                                    </script>
                                <? } else {

                                    echo mysqli_error($con);
                                ?>

                                    <script>
                                        swal("Oops !", "Call Updated Error !", "error");

                                        setTimeout(function() {
                                            // window.location.href="mis_details.php?id=<? echo $id; ?>";
                                        }, 2000);
                                    </script>

                            <? }
                            }

                            ?>

                            <form action="<? echo $_SERVER['PHP_SELF']; ?>?id=<? echo $id; ?>" method="POST" enctype="multipart/form-data">
                                <div class="row" id="status_col"></div>
                            </form>


                        </div>
                    </div>




                    <div class="card">
                        <div class="card-block" style="overflow:scroll;">
                            <h5>CALL DISPATCH INFORMATION</h5>

                            <hr>
                            <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
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
                                        <th>Dependency</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?
                                    // echo "select * from mis_history  where mis_id ='".$id."'"; 

                                    $his_sql = mysqli_query($con, "select * from mis_history  where mis_id ='" . $id . "'");
                                    $i = 1;
                                    while ($his_sql_result = mysqli_fetch_assoc($his_sql)) {
                                        $is_material_dept = $his_sql_result['is_material_dept'];
                                    ?>
                                        <tr <? if ($is_material_dept == 1) { ?> style="background-color: #404e67;color:white;" <? } ?>>
                                            <td><? echo $i; ?></td>
                                            <td><? echo $his_sql_result['type'];  ?></td>
                                            <td><? echo $his_sql_result['remark'];  ?></td>
                                            <td><? echo $his_sql_result['created_at'];  ?></td>
                                            <td><? if ($his_sql_result['schedule_date'] != '0000-00-00') {
                                                    echo $his_sql_result['schedule_date'];
                                                }  ?></td>
                                            <td><? echo $his_sql_result['material'];  ?></td>
                                            <td><? echo getUsername($his_sql_result['engineer'], true);  ?></td>
                                            <td><? echo $his_sql_result['pod'];  ?></td>
                                            <td><? echo getUsername($his_sql_result['created_by'], true);  ?></td>
                                            <td> <? if ($his_sql_result['attachment']) { ?><a href="<? echo $his_sql_result['attachment'];  ?>" target="_blank">View Attchment</a> <? } ?></td>
                                            <td> <? if ($his_sql_result['attachment2']) { ?><a href="<? echo $his_sql_result['attachment2'];  ?>" target="_blank">View Attchment</a> <? } ?></td>

                                            <td><? if ($his_sql_result['delivery_date'] != '0000-00-00') {
                                                    echo $his_sql_result['delivery_date'];
                                                }  ?></td>
                                            <td><? echo $his_sql_result['delivery_address'];  ?></td>
                                            <td><? echo $his_sql_result['serial_number'];  ?></td>
                                            <td><? echo $his_sql_result['dependency'];  ?></td>


                                        </tr>
                                    <? $i++;
                                    } ?>

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
    console.clear();

    function handleCheckboxChange(checkbox, matLoopCount) {
        // Get the corresponding select and input elements based on the matLoopCount
        var selectElement = document.getElementById("select_" + matLoopCount);
        var inputElement = document.getElementById("input_" + matLoopCount);

        // Check if the select and input elements exist before setting the 'required' attribute
        if (selectElement && inputElement) {
            if (checkbox.checked) {
                selectElement.required = true;
                inputElement.required = true;
            } else {
                selectElement.required = false;
                inputElement.required = false;
            }
        }
    }


    $(document).ready(function() {

        $(document).on('change', '#status', function() {

            console.log("Checkbox:", this);

            var status = $(this).val();
            $("#status_col").html('');


            if (status == 'close') {
                var html = `<input type="hidden" name="status" value="close">

            <div class="col-sm-12"><label>Snap</label><br /><input type="file" name="image" required></div>
            <div class="col-sm-12"><br><label>Remark</label><input type="text" name="remark" class="form-control"></div>
            <div class="col-sm-12"><br><label>Resolution</label>
                <select name="" class="form-control" required>
                <option value="Spares Replaced">Spares Replaced</option>
                <option value="Antena relocated">Antenna relocated</option>
                    <option value="Antena replaced">Antenna replaced</option>
                    <option value="Loose connection fixed">Loose connection fixed</option>
                    <option value="Power turned on">Power turned on</option>
                    <option value="Router rebooted">Router rebooted</option>
                    <option value="Lab cable replaced or label fixed (if damaged).">Lab cable replaced or label fixed (if damaged).</option>
                    <option value="Electrical wiring done">Electrical wiring done</option>
                    <option value="SIM replaced">SIM replaced</option>
                    <option value="SIM re-inserted">SIM re-inserted</option>
                    <option value="No issue found">No issue found</option>
                </select>
                </div>


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

            <div class="col-sm-12"><br><br><input class="btn btn-primary" value="Close" type="submit" name="submit"></div>`;
            } else if (status == 'material_requirement') {
                var html = `
                <input type="hidden" name="status" value="material_requirement">
                <div class="col-sm-12">
                    <label>Please Select Material </label>
                    <br />
                    <div class="border-checkbox-section" style="margin: auto 40px;">
                    <?
                    $matLoopCount = 1;
                    $mat_sql = mysqli_query($con, "select * from boq where status=1");
                    while ($mat_sqlResult = mysqli_fetch_assoc($mat_sql)) {
                        $value = $mat_sqlResult['value']; ?>
                        <div class="border-checkbox-group border-checkbox-group-primary">
                            <input class="border-checkbox" name="requiredMaterial[]" type="checkbox" id="checkbox<?= $matLoopCount; ?>" value="<?= trim($value); ?>">

                            <label class="border-checkbox-label" for="checkbox<?= $matLoopCount; ?>"><?= trim($value); ?></label>

                            <select id="select_<?= $matLoopCount; ?>" name="material_condition[]">
                                <option value="">Select</option>
                                <option value="Missing">Missing</option>
                                <option value="Faulty">Faulty</option>
                                <option value="Not Installed">Not Installed</option>
                            </select>

                            <input id="input_<?= $matLoopCount; ?>" type="file" name="material_requirement_images[]" />
                        </div>
                        
                        <? $matLoopCount++;
                    } ?>
                    </div>

                    <div class="col-sm-12">
                        <label>Remarks</label>
                        <input type="text" name="remark" class="form-control" required />
                    </div>
                    <div class="col-sm-12">
                        <br />
                        <input type="submit" name="submit" class="btn btn-primary" />
                    </div>
                    
                </div>
            `;
            } else if (status == 'reassign') {
                var html = `<input type="hidden" name="status" value="reassign">


            <div class="border-checkbox-section highlight" style="width:75%">
                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                <input class="border-checkbox" name="noProblemOccurs[]" type="checkbox"
                                                    id="checkbox1" value="Ups Wroking">
                                                <label class="border-checkbox-label" for="checkbox1">Ups Not Wroking</label>
                                            </div>
                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                <input class="border-checkbox" name="noProblemOccurs[]" type="checkbox"
                                                    id="checkbox2" value="No Power Outage">
                                                <label class="border-checkbox-label" for="checkbox2">Power Outage</label>
                                            </div>
                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                <input class="border-checkbox" name="noProblemOccurs[]" type="checkbox"
                                                    id="checkbox3" value="No Problen in Machine Hardware">
                                                <label class="border-checkbox-label" for="checkbox3">Machine Hardware Issue</label>
                                            </div>

                                        </div>


            <div class="col-sm-12">
                <label>Snap</label><br />
                <input type="file" name="image" required>
            </div>
            <div class="col-sm-12">
            <br />
                <label>Remark</label>
                <input type="text" name="remark" class="form-control">
            </div>

            <div class="col-sm-12">
                        <br />
                        <input type="submit" name="submit" class="btn btn-primary" />
                    </div>
                    
            `;
            } else if (status == 'schedule') {
                var html = `<input type="hidden" name="status" value="schedule">
            <div class="col-sm-4">
            <label>Engineer</label>
            <select name="engineer" class="form-control">
            <option value="">Select</option>
            <? $eng_sql = mysqli_query($con, "select * from vendorusers where level=3 order by name asc");
            while ($eng_sql_result = mysqli_fetch_assoc($eng_sql)) { ?> 
            <option value="<? echo $eng_sql_result['id']; ?>">
            <?= ucwords(strtolower($eng_sql_result['name'])); ?>
            </option> <? } ?>
            
            </select>
            </div>
            <div class="col-sm-4"><label>Remark</label><input type="text" name="remark" class="form-control"></div>
            <div class="col-sm-4"><label>Schedule Date</label><input type="date" name="schedule_date" class="form-control"></div>
            <div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>`;
            } else if (status == 'material_dispatch') {
                var html = `
            <input type="hidden" name="status" value="material_dispatch">
            <div class="col-sm-3">
            <label>Courier Agency</label>
            <input type="text" name="courier" class="form-control">
            </div>
            <div class="col-sm-3">
            <label>POD</label>
            <input type="text" name="pod" class="form-control">
            </div>
            <div class="col-sm-3">
            <label>Dispatch Date</label>
            <input type="date" name="dispatch_date" class="form-control">
            </div>
            <div class="col-sm-3">
            <label>Remark</label>
            <input type="text" name="remark" class="form-control">
            </div>
            <div class="col-sm-4">
            <br>
            <input class="btn btn-primary" type="submit" value="Update" name="submit">
            </div>`;
            }

            $("#status_col").html(html);
        });

        $(document).on('change', '.border-checkbox', function() {
            // Get the matLoopCount from the checkbox's ID
            var matLoopCount = this.id.replace('checkbox', '');
            handleCheckboxChange(this, matLoopCount);
        });
    });

    function throttle(f, delay) {
        var timer = null;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = window.setTimeout(function() {
                    f.apply(context, args);
                },
                delay || 1000);
        };
    }


    $(document).ready(function() {
        $(".js-example-basic-single").select2();
    });


    function setaddress() {
        var address_type = $('#address_type').val();
        if (address_type == 'Branch') {
            $('#address').val('Branch');
            $('#address').attr('readonly', true);
            $('#Contactperson_name').hide();
            $('#Contactperson_mob').hide();
            $('#Contactperson_name_text').attr('required', false);
            $('#Contactperson_mob_text').attr('required', false);
            $('#address').show();
        }
        if (address_type == 'Other') {
            $('#address').val('');
            $('#address').attr('readonly', false);
            $('#Contactperson_name').show();
            $('#Contactperson_mob').show();
            $('#Contactperson_name_text').attr('required', true);
            $('#Contactperson_mob_text').attr('required', true);
            //  $('#address').show();
        }
    }




    $(document).on('keyup', '#address', throttle(function() {
        $("#item_name").html('');
        add = $(this).val();
        $.ajax({
            type: "POST",
            url: 'suggested_address.php',
            data: 'address=' + add,
            success: function(msg) {

                $("#item_name").append(msg);


            }
        });
        //   alert(add);
    }));
</script>






<? include('footer.php'); ?>

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