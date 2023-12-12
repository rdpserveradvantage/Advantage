<? include('header.php');

error_reporting(0);



if ($_SESSION['SERVICE_level'] == 5) { ?>

    <script>
        window.location.href = "bankAddMis.php";
    </script>
<? }

?>



<style>
    .chighlight {
        border: 2px solid red;
    }
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">

                            <form id="form" method="POST">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Atmid</label>
                                        <input type="text" id="atmid" class="form-control" list="atmidOptions"
                                            name="atmid">
                                        <datalist id="atmidOptions"></datalist>
                                    </div>


                                    <div class="col-sm-4">
                                        <label class="label_label">Bank</label>
                                        <input type="text" name="bank" id="bank" class="form-control">
                                    </div>

                                    <div class="col-sm-4">
                                        <label>Customer</label>
                                        <select class="form-control" id="customer" name="customer" required>
                                            <option value="">Select Customer</option>
                                            <? $con_sql = mysqli_query($con, "select distinct(customer) as customer from sites where status=1");
                                            while ($con_sql_result = mysqli_fetch_assoc($con_sql)) { ?>
                                                <option value="<? echo strtoupper($con_sql_result['customer']); ?>">
                                                    <? echo strtoupper($con_sql_result['customer']); ?>
                                                </option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="label_label">Region</label>
                                        <input class="form-control" type="text" name="region" id="region"
                                            value="<? echo $region; ?>">
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="label_label">City</label>
                                        <input class="form-control" type="text" name="city" id="city"
                                            value="<? echo $city; ?>" required>
                                    </div>

                                    <div class="col-sm-4">
                                        <label class="label_label">State</label>
                                        <select name="state" id="state" class="form-control" required>
                                            <option value="">Select State</option>
                                            <?
                                            $state_sql = mysqli_query($con, "select distinct(state) as state from sites where status=1");
                                            while ($state_sql_result = mysqli_fetch_assoc($state_sql)) { ?>
                                                <option value="<? echo $state_sql_result['state']; ?>" <? if ($state == $state_sql_result['state']) {
                                                       echo 'selected';
                                                   } ?>>
                                                    <? echo $state_sql_result['state']; ?>
                                                </option>
                                            <? } ?>
                                        </select>

                                    </div>
                                    <div class="col-sm-12">
                                        <label class="label_label">Locations</label>
                                        <input class="form-control" type="text" name="location" id="location"
                                            value="<? echo $location; ?>">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="label_label">Engineer</label>
                                        <select class="form-control" name="engineer" id="engineer">
                                            <option>-- Select --</option>
                                            <?
                                            $eng_sql = mysqli_query($con, "select * from vendorUsers where level=3 and user_status=1 order by name asc");
                                            while ($eng_sql_result = mysqli_fetch_assoc($eng_sql)) {
                                                $engid = $eng_sql_result['id'];
                                                $engname = $eng_sql_result['name'];
                                                ?>
                                                <option value="<? echo $engid; ?>">
                                                    <? echo ucwords(strtolower($engname)); ?>
                                                </option>
                                            <? }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label>LHO</label>
                                        <input type="text" name="lho" id="lho" class="form-control" value="" required>
                                    </div>

                                    <div class="col-sm-4">
                                        <label>Call Type</label>
                                        <input type="text" name="call_type" id="call_type" class="form-control"
                                            value="Service" readonly required>
                                    </div>

                                </div>




                                <div class="row highlight">

                                    <? if ($_SESSION['SERVICE_level'] != 5) { ?>
                                        <div class="col-sm-12">
                                            <label>Call Receive From</label>
                                            <select class="form-control" name="call_receive" id="call_receive" reuqired>
                                                <option value="">Select</option>
                                                <option value="Customer / Bank">Customer / Bank</option>
                                                <option value="Internal">Internal</option>
                                            </select>
                                        </div>

                                    <? } ?>


                                    <div class="col-sm-6">
                                        <label>Issue</label>
                                        <select name="comp" id="comp" class="form-control" required>
                                            <option value="">Select</option>
                                            <option>Offline</option>
                                            <option>Non-Offline</option>
                                            <option>VPN-down</option>

                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Reason</label>
                                        <select name="subcomp" id="subcomp" class="form-control" required>
                                        </select>
                                    </div>


                                </div>



                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" id="remarks"></textarea>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <button type="button" id="saveButton" class="btn btn-primary"> Create Call
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div id="show_history"></div>
                </div>
            </div>


        </div>
    </div>
</div>


<script>


    $(document).on('change', '#comp', function () {
        var comp = $(this).val();
        if (comp == 'Offline') {
            option = '<option>Router Offline</option>';
        } else if (comp == 'Non-Offline') {
            option = `<option>Weak Signal</option>
                    <option>Fluctuation</option>
                    <option>SIM Slot Not Working</option>

        `;
        } else if (comp == 'VPN-down') {
            option = `<option>VPN-down</option>`;

        }
        else {
            option = `<option></option>`;
        }
        $("#subcomp").html(option);
    })

    $(document).ready(function () {
        $("#atmid").focus();


        function checkOpenCall(atmid) {
            $.ajax({
                type: "POST",
                url: 'check_open_call.php', // Replace with the PHP script to check open calls
                data: { atmid: atmid },
                success: function (response) {
                    if (response.openCall) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Open Call Exists',
                            text: 'An open call already exists for this ATM ID.',
                            confirmButtonText: 'OK'
                        }).then(function () {
                            // Reset the form
                            $("#form")[0].reset();
                        });
                    }
                }
            });
        }

        $("#atmid").on('blur', function () {
            var atmid = $(this).val();
            if (atmid !== "") {
                checkOpenCall(atmid);
            }
        });


    });


    $(document).ready(function () {
        function populateATMData(atmid) {
            $.ajax({
                type: "POST",
                url: 'get_atm_data.php',
                data: 'atmid=' + atmid,
                success: function (msg) {
                    console.log(msg);

                    if (msg != 0) {
                        var obj = JSON.parse(msg);
                        var fields = ['customer', 'bank', 'engineer', 'location', 'region', 'state', 'city', 'branch', 'bm', 'lho'];

                        fields.forEach(function (field) {
                            if (!obj[field]) {
                                $("#" + field).focus();
                            } else {
                                $("#" + field).val(obj[field]);
                                $('#' + field).attr('readonly', true);
                            }
                        });

                        if (obj.customer && obj.bank && obj.location && obj.region && obj.state && obj.city && obj.branch && obj.bm && obj.lho) {
                            $("#call_receive").focus();
                        }

                        $("#call_type").focus();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No Info With This ATM',
                        }).then(function () {
                            // Reset the form
                            $("#form")[0].reset();
                        });

                    }
                }
            });

            $.ajax({
                type: "POST",
                url: 'show_history.php',
                data: 'atmid=' + atmid,
                success: function (msg) {
                    $("#show_history").html(msg);
                }
            });
        }

        $("#atmid").on('input', function () {
            var input = $(this).val();

            $.ajax({
                type: "POST",
                url: 'get_suggestions.php',
                data: { input: input },
                success: function (response) {
                    console.log(response)
                    var datalist = $("#atmidOptions");
                    datalist.empty();

                    var suggestions = JSON.parse(response);

                    suggestions.forEach(function (suggestion) {
                        datalist.append($("<option>").attr('value', suggestion).text(suggestion));
                    });
                }
            });
        });

        $("#atmid").on('change', function () {
            var atmid = $(this).val();
            populateATMData(atmid);
        });
    });





    $("#saveButton").on('click', function () {

        var atmid = $("#atmid").val();
        var remarks = $("#remarks").val();
        var fieldsToHighlight = [];

        if (atmid === "") {
            fieldsToHighlight.push("#atmid");
        } else {
            fieldsToHighlight.pop("#atmid");
        }

        if (remarks === "") {
            fieldsToHighlight.push("#remarks");
        } else {
            fieldsToHighlight.pop("#remarks");
        }

        if (fieldsToHighlight.length > 0) {
            fieldsToHighlight.forEach(function (fieldId) {
                console.log(fieldId);
                $(fieldId).addClass("chighlight");
            });

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill in all required fields.'
            });

            return false; // Prevent form submission
        }
        // Remove highlighting from fields
        $(".chighlight").removeClass("chighlight");

        var formData = $("#form").serialize();
        $.ajax({
            type: "POST",
            url: 'process_addMis.php', // Replace with your PHP script to save form data
            data: formData,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(function () {
                        // Reset the form
                        $("#form")[0].reset();
                    });
                } else {
                    // Show error message using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                // Show error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving the form data.'
                });
            }
        });
    });










</script>






<? include('footer.php'); ?>