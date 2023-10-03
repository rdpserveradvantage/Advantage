<?php include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

  <!--<script src="https://unpkg.com/js-datepicker@5.18.2/dist/datepicker.min.js"></script>-->


                    <div class="card">
                        <div class="card-block">
                            <?php
                            $atmid = $_REQUEST['atmid'];
                            $id = $_REQUEST['id'];
                            ?>
                            <h5 style="font-weight: 600;">Proceed Installation : <span style="color:red; "><?php echo $atmid . ' '; ?></span>To Vendor</h5>
                            <hr>
                            <form id="myForm2" enctype="multipart/form-data">
                                <input type="hidden" name="atmid" value="<?php echo $atmid; ?>" />
                                <input type="hidden" name="siteid" value="<?php echo $id; ?>" />
                            
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Select Vendor For Installation</label>
                                        <select name="vendor" class="form-control" required>
                                            <option value="">SELECT</option>
                                            <?php
                                            $sql2 = mysqli_query($con, "select * from vendor where status=1");
                                            while ($sql_result2 = mysqli_fetch_assoc($sql2)) {
                                                $vendorid = $sql_result2['id'];
                                                $vendorname = $sql_result2['vendorName'];
                                            ?>
                                                <option value="<?php echo $vendorid; ?>">
                                                    <?php echo strtoupper($vendorname); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>SBIN Ticket ID</label>
                                        <input type="text" name="sbiTicketId" class="form-control" required />
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                         <label>Schedule ATM Engineer</label>
                                         <input type="text" name="scheduleAtmEngineerName" class="form-control" required />
                                     </div>
                                    
                                    <div class="col-sm-6">
                                        <label>Schedule ATM Engineer Number</label>
                                        <input type="text" name="scheduleAtmEngineerNumber" class="form-control" required />
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                     <div class="col-sm-6">
                                         <label>Bank Person</label>
                                         <input type="text" name="bankPersonName" class="form-control" required />
                                     </div>
                                    
                                    <div class="col-sm-6">
                                        <label>Bank Person Number</label>
                                        <input type="text" name="bankPersonNumber" class="form-control" required />
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                         <label>Back-room key Person </label>
                                         <input type="text" name="backRoomKeyPersonName" class="form-control" required />
                                     </div>
                                    
                                    <div class="col-sm-6">
                                        <label>BACK-ROOM KEY PERSON NUMBER</label>
                                        <input type="text" name="backRoomKeyPersonNumber" class="form-control" required />
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="dateInput">Select a date:</label>
                                        <input type="date" id="dateInput" class="form-control" name="scheduleDate" pattern="\d{2}-\d{2}-\d{4}"  required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="timeInput">Select a time:</label>
                                        <input type="time" id="timeInput" class="form-control" name="scheduleTime" required>
                                        <button type="button" onclick="closeTimePicker()">Close Time Picker</button>
                                    </div>
                                </div>
                
                

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <button type="submit" class="btn btn-success" onclick="saveForm2()">Proceed To Installation</button>
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


    function saveForm2() {
        
        event.preventDefault();
        var formData = new FormData($('#myForm2')[0]);
        var requiredFields = $('#myForm2 :required');
        var emptyFields = [];
        

        requiredFields.each(function () {
            if ($(this).val() === '') {
                emptyFields.push($(this).attr('name'));
            }
        });


        if (emptyFields.length > 0) {
            swal("Error", "Please fill in all the required fields!", "error");
            $('input, select').removeClass('highlight');
            $.each(emptyFields, function (index, fieldName) {
                $('[name="' + fieldName + '"]').addClass('highlight');
            });
            return;
        }

        $.ajax({
            url: 'process_sendtoInstallation.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response == 202) {
                    swal("Success", "Installation Request Sent Successfully!", "success");
                    setTimeout(function () {
                        window.location.href = "sitestest.php";
                    }, 3000); // Redirect after 3 seconds
                } else {
                    alert('Added Error!');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                alert('Added Error!');
            }
        });
    }
</script>

<?php include('footer.php'); ?>
