<?php include('header.php'); ?>

<style>
  .swal2-popup {
    background: white !important;
}


</style>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- <div class="card" style="display:none;">
                        <div class="card-block">
                            <?php
                            $atmid = $_REQUEST['atmid'];
                            $id = $_REQUEST['id'];
                            $action = $_REQUEST['action'];
                            ?>
                            <h5>Delegate : <span style="color:red; "><?php echo $atmid . ' '; ?></span>To Engineer</h5>
                            <hr>
                            <form id="myForm1" enctype="multipart/form-data">
                                <input type="hidden" name="atmid" value="<?php echo $atmid; ?>" />
                                <input type="hidden" name="siteid" value="<?php echo $id; ?>" />
                                <input type="hidden" name="action" value="<?php echo $action; ?>" />
                                <input type="hidden" name="delegateTo" value="selfEngineer" />

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Engineer</label>
                                        <select name="engineer" class="form-control" required>
                                            <option value="">Select</option>
                                            <?php
                                            $sql = mysqli_query($con, "select * from mis_loginusers where user_status=1 and level=3");
                                            while ($sql_result = mysqli_fetch_assoc($sql)) {
                                                $engineerid = $sql_result['id'];
                                                $name = $sql_result['name'];
                                            ?>
                                                <option value="<?php echo $engineerid; ?>">
                                                    <?php echo $name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <button type="submit" class="btn btn-success" onclick="saveForm1()">Save</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div> -->

                    <div class="card">
                        <div class="card-block">
                            <?php
                            $atmid = $_REQUEST['atmid'];
                            $id = $_REQUEST['id'];
                            $action = $_REQUEST['action'];
                            ?>
                            <h5>Delegate : <span style="color:red; "><?php echo $atmid . ' '; ?></span>To Vendor</h5>
                            <hr>
                            <form id="myForm2" enctype="multipart/form-data">
                                <input type="hidden" name="atmid" value="<?php echo $atmid; ?>" />
                                <input type="hidden" name="siteid" value="<?php echo $id; ?>" />
                                <input type="hidden" name="action" value="<?php echo $action; ?>" />
                                <input type="hidden" name="delegateTo" value="vendor" />

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Vendor</label>
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
                                        <button type="submit" class="btn btn-success" onclick="saveForm2()">Save</button>
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
    // function saveForm1() {
    //     event.preventDefault();
    //     var formData = new FormData($('#myForm1')[0]);
    //     var requiredFields = $('#myForm1 :required');
    //     var emptyFields = [];

    //     // Check for empty required fields
    //     requiredFields.each(function () {
    //         if ($(this).val() === '') {
    //             emptyFields.push($(this).attr('name'));
    //         }
    //     });

    //     if (emptyFields.length > 0) {
    //         swal("Error", "Please fill in all the required fields!", "error");
    //         $('input, select').removeClass('highlight');
    //         $.each(emptyFields, function (index, fieldName) {
    //             $('[name="' + fieldName + '"]').addClass('highlight');
    //         });
    //         return; // Exit the function if empty fields exist
    //     }

    //     $.ajax({
    //         url: 'process_delegate.php',
    //         type: 'POST',
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function (response) {
    //             console.log(response);
    //             if (response == 200) {
    //                 swal("Success", "Delegated Successfully!", "success");
    //                 // setTimeout(function () {
    //                 //     window.location.href = "sitestest.php";
    //                 // }, 3000); // Redirect after 3 seconds
    //             } else if (response == 202) {
    //                 swal("Success", "Re-Delegated Successfully!", "success");
    //                 // setTimeout(function () {
    //                 //     window.location.href = "sitestest.php";
    //                 // }, 3000); // Redirect after 3 seconds
    //             } else {
    //                 alert('Added Error!');
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.error(error);
    //             alert('Added Error!');
    //         }
    //     });
    // }


    function saveForm2() {
    event.preventDefault();
    var formData = new FormData($('#myForm2')[0]);
    var requiredFields = $('#myForm2 :required');
    var emptyFields = [];

    // Check for empty required fields
    requiredFields.each(function () {
        if ($(this).val() === '') {
            emptyFields.push($(this).attr('name'));
        }
    });

    if (emptyFields.length > 0) {
        Swal.fire("Error", "Please fill in all the required fields!", "error");
        $('input, select').removeClass('highlight');
        $.each(emptyFields, function (index, fieldName) {
            $('[name="' + fieldName + '"]').addClass('highlight');
        });
        return; // Exit the function if empty fields exist
    }

    $.ajax({
        url: 'process_delegate.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);

            if (response == 200 || response == 202) {
                Swal.fire("Success", "Delegated To Vendor Successfully!", "success")
                    .then(function () {
                        window.location.href = "sitestest.php";
                    });
            } else {
                console.error('Added Error!');
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
