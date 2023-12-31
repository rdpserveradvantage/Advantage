<?php include('header.php'); ?>


<style>
    .form-control {
        font-size: 16px !important;
        border-radius: 2px;
        border: 1px solid #ccc;
    }
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
                            <div class="two_end">
                                <h5>Router Configuration <span style="font-size:12px; color:red;">(add router serial number along with seal number)</span></h5>
                            </div>
                            <hr>
                            <form id="routerConfigForm" action="<? $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="form-group">
                                    <label>Serial No</label>
                                    <input type="text" id="serial_no" class="form-control" list="serial_noOptions" name="serial_no" autocomplete="off" required>
                                    <datalist id="serial_noOptions"></datalist>
                                </div>
                                <div class="row" id="IPinfoBox" style="display:none">
                                    <input type="hidden" name="ipID" id="ipID" value="" />
                                    <div class="col-sm-12" id="msgDiv" style="display:none;">
                                        Message : <label id="msg"></label>
                                    </div>

                                    <div class="col-sm-12">
                                        <label>Network IP</label>
                                        <input class="form-control" readonly type="text" name="network_ip" id="network_ip" value="">
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Router IP</label>
                                        <input class="form-control" readonly type="text" name="router_ip" id="router_ip" value="">
                                    </div>

                                    <div class="col-sm-12">
                                        <label>ATM IP</label>
                                        <input class="form-control" readonly type="text" name="atm_ip" id="atm_ip" value="">
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Subnet Mask</label>
                                        <input class="form-control" readonly type="text" name="subnet_mask" id="subnet_mask" value="">
                                    </div>
                                </div>
                                <br />
                                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Configure">
                            </form>
                        </div>
                    </div>

                    <?

                    if (isset($_REQUEST['submit'])) {

                    ?>



                        <div class="card">
                            <div class="card-body">
                                <?

                                $serial_no = $_REQUEST["serial_no"];
                                $router_ip = $_REQUEST["router_ip"];
                                $network_ip = $_REQUEST["network_ip"];
                                $atm_ip = $_REQUEST["atm_ip"];
                                $subnet_mask = $_REQUEST["subnet_mask"];
                                $ipID = $_REQUEST['ipID'];

                                if ($ipID > 0) {
                                    if (mysqli_query($con, "update inventory set isIPAssign=1 where serial_no='" . $serial_no . "'")) {
                                        echo '<h5>IP Assigned To Serial Number : ' . $serial_no . '</h5>';
                                        mysqli_query($con, "update ips set isAssign=1 where id='" . $ipID . "'");
                                        mysqli_query($con, "insert into ipconfuration(ipID, serial_no, router_ip, network_ip, atm_ip, subnet_ip, created_at, created_by, status)
                                    values('" . $ipID . "','" . $serial_no . "','" . $router_ip . "','" . $network_ip . "','" . $atm_ip . "','" . $subnet_mask . "','" . $datetime . "','" . $userid . "',1)");
                                    } else {
                                        echo '<h5>Error In IP Assigned To Serial Number : ' . $serial_no . '</h5>';
                                    }
                                } else {
                                    echo '<h5>Something Wrong</h5>';
                                }


                                ?>
                            </div>
                        </div>




                    <? }


                    ?>



                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $("#serial_no").on('input', function() {
            var input = $(this).val();

            $.ajax({
                type: "POST",
                url: 'get_serialno_suggestions.php',
                data: {
                    input: input
                },
                success: function(response) {
                    console.log(response)
                    var datalist = $("#serial_noOptions");
                    datalist.empty();

                    var suggestions = JSON.parse(response);

                    suggestions.forEach(function(suggestion) {
                        datalist.append($("<option>").attr('value', suggestion).text(suggestion));
                    });
                }
            });
        });


        $("#serial_no").on('change', function() {
            var serial_no = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'get_unAssignedIP.php',
                data: 'serial_no=' + serial_no,
                success: function(response) {
                    console.log(response);
                    if (response == 0) {
                        alert("No IP addresses available.");
                        $("#IPinfoBox").css('display', 'none');
                    } else {
                        var ipAddresses = JSON.parse(response);

                        $("#router_ip").val(ipAddresses.router_ip);
                        $("#network_ip").val(ipAddresses.network_ip);
                        $("#atm_ip").val(ipAddresses.atm_ip);
                        $("#subnet_mask").val(ipAddresses.subnet_ip);
                        $("#ipID").val(ipAddresses.id);
                        if (ipAddresses.msg) {
                            $("#msgDiv").css('display', 'block')
                            $("#msg").html(ipAddresses.msg);
                            $("#submit").css('display', 'none');
                        } else {
                            $("#msgDiv").css('display', 'none');
                            $("#submit").css('display', 'block');

                        }
                        // Clear the input value from the datalist's options
                        $("#serial_noOptions option[value='" + serial_no + "']").remove();

                        $("#IPinfoBox").css('display', 'flex');

                        // Change focus to another element, for example, the submit button
                        $("#router_ip").focus();
                    }
                }
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("routerConfigForm");

        form.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent the form from submitting
            }
        });
    });
</script>

<?php include('footer.php'); ?>