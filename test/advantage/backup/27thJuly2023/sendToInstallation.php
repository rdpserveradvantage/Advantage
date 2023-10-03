<?php include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">


                    <div class="card">
                        <div class="card-block">
                            <?php
                            $atmid = $_REQUEST['atmid'];
                            $id = $_REQUEST['id'];
                            ?>
                            <h5>Proceed Installation : <span style="color:red; "><?php echo $atmid . ' '; ?></span>To Vendor</h5>
                            <hr>
                            <form id="myForm2" enctype="multipart/form-data">
                                <input type="hidden" name="atmid" value="<?php echo $atmid; ?>" />
                                <input type="hidden" name="siteid" value="<?php echo $id; ?>" />
                            
                                <div class="row">
                                    <div class="col-sm-12">
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
            return; // Exit the function if empty fields exist
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
