<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        <?
                                        $atmid = $_REQUEST['atmid'];
                                        $id = $_REQUEST['id'];
                                        $siteid = $_REQUEST['siteid'];
                                        
                                        $sql = mysqli_query($con,"select * from  projectInstallation where siteid='".$siteid."' order by id desc");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        $scheduleAtmEngineerName = $sql_result['scheduleAtmEngineerName'];
                                        $scheduleAtmEngineerNumber = $sql_result['scheduleAtmEngineerNumber'];
                                        $bankPersonName = $sql_result['bankPersonName'];
                                        $bankPersonNumber = $sql_result['bankPersonNumber'];
                                        $backRoomKeyPersonName = $sql_result['backRoomKeyPersonName'];
                                        $backRoomKeyPersonNumber = $sql_result['backRoomKeyPersonNumber'];
                                        $sbiTicketId = $sql_result['sbiTicketId'];
                                        $scheduleDate = $sql_result['scheduleDate'];
                                        $scheduleTime = $sql_result['scheduleTime'];



                                        ?>
                                        <h5 style="font-weight: 600;">Proceed Installation : <span style="color:red; "><?php echo $atmid . ' '; ?></span>To Engineer</h5>
                                        <!--<h4>Assign ATMID: <? echo $atmid ; ?> For Installation</h4>-->
                                        <hr>
                                        <form id="myForm" enctype="multipart/form-data">
                                        <!--<form action="process_delegate.php" method="POST">-->
                                            <input type="hidden" name="atmid" value="<? echo $atmid ; ?>" />
                                            <input type="hidden" name="id" value="<? echo $id ; ?>" />
                                            <input type="hidden" name="siteid" value="<? echo $siteid ; ?>" />
                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Select Engineer For Installation </label>

                                                    <select name="engineer" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <?
                                                        $sql = mysqli_query($con,"select * from vendorUsers where user_status=1 and vendorId='".$RailTailVendorID."' and level=3");
                                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                                        $engineerid = $sql_result['id'];
                                                        $name = $sql_result['name'];
                                                        ?>
                                                        <option value="<? echo $engineerid; ?>">
                                                            <? echo $name; ?>
                                                        </option>
                                                            
                                                            
                                                        <? } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>SBIN Ticket ID</label>
                                                    <input type="text" name="sbiTicketId" class="form-control"  value="<?php echo $sbiTicketId; ?>"  <? if(isset($sbiTicketId) && !empty($sbiTicketId)){ echo 'readonly' ; } ?> required />
                                                </div>
                                            </div>
                                            <hr>
                                            
                                                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Schedule ATM engineer</label>
                                                    <input type="text" name="scheduleAtmEngineerName" class="form-control" required value="<?php echo $scheduleAtmEngineerName; ?>"  <? if(isset($scheduleAtmEngineerName)){ echo 'readonly' ; } ?> />
                                                </div>
                                                                                
                                                <div class="col-sm-6">
                                                    <label>Schedule ATM engineer Number</label>
                                                    <input type="text" name="scheduleAtmEngineerNumber" class="form-control" required value="<?php echo $scheduleAtmEngineerNumber; ?>" <? if(isset($scheduleAtmEngineerNumber)){ echo 'readonly' ; } ?> />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Bank Person</label>
                                                    <input type="text" name="bankPersonName" class="form-control" required value="<?php echo $bankPersonName; ?>" <? if(isset($bankPersonName)){ echo 'readonly' ; } ?> />
                                                </div>
                                                                                
                                                <div class="col-sm-6">
                                                    <label>Bank Person Number</label>
                                                    <input type="text" name="bankPersonNumber" class="form-control" required value="<?php echo $bankPersonNumber; ?>" <? if(isset($bankPersonNumber)){ echo 'readonly' ; } ?> />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Back-room key Person</label>
                                                    <input type="text" name="backRoomKeyPersonName" class="form-control" required value="<?php echo $backRoomKeyPersonName; ?>" <? if(isset($backRoomKeyPersonName)){ echo 'readonly' ; } ?> />
                                                </div>
                                                                                
                                                <div class="col-sm-6">
                                                    <label>Back-room key Person Number</label>
                                                    <input type="text" name="backRoomKeyPersonNumber" class="form-control" required value="<?php echo $backRoomKeyPersonNumber; ?>" <? if(isset($backRoomKeyPersonNumber)){ echo 'readonly' ; } ?> />
                                                </div>
                                            </div>
                                            <hr>
                                            
                                            <div class="row">    
                                                <div class="col-sm-6">
                                                    <label for="dateInput">scheduled Date :</label>
                                                    <input type="date" id="dateInput" name="date" class="form-control" value="<? echo $scheduleDate; ?>" readonly required>    
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="timeInput">scheduled time:</label>
                                                    <input type="time" id="timeInput" name="time" class="form-control" value="<? echo $scheduleTime; ?>" readonly required>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <br>
                                                    <button type="submit" class="btn btn-success" onclick="saveForm()">Assign For Installation</button>
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
              
              
<script>
    function saveForm() {
    event.preventDefault();
    var formData = new FormData($('#myForm')[0]);
    var requiredFields = $('#myForm :required');
    var emptyFields = [];

    // Check for empty required fields
    requiredFields.each(function() {
        if ($(this).val() === '') {
            emptyFields.push($(this).attr('name'));
        }
    });

    if (emptyFields.length > 0) {
        swal("Error", "Please fill in all the required fields!", "error");
        $('input, select').removeClass('highlight');
        $.each(emptyFields, function(index, fieldName) {
            $('[name="' + fieldName + '"]').addClass('highlight');
        });
        return; // Exit the function if empty fields exist
    }

        $.ajax({
            url: 'process_assignProjectInstallation.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response == 200) {
                    swal("Success", "Assigned Successfully!", "success");
                    setTimeout(function() {
                        window.location.href = "projectLeads.php";
                    }, 3000); // Redirect after 3 seconds
                } else {
                    alert('Assigned Error!');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Assigned Error!');
            }
        });

}

              </script>      
                    
    <? include('footer.php'); ?>
    