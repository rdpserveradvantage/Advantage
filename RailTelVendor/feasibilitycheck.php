<? include('header.php'); ?>

<style>

    .highlight {
        border-color: red;
    }
    select:focus,
    input:focus {
        border-bottom: 1px solid red !important;
    }
    input.form-control,
    input {
        border: none;
        margin: 10px auto;
    }

    .form-control:focus {
        color: #55595c;
        background-color: #fff;
        border-color: #66afe9;
        outline: none;
        box-shadow: none;
        border: none;
    }

    .highlight {
        border-color: red;
    }
    .swal-overlay {
        background-color: rgba(43, 165, 137, 0.45);
    }

    input.form-control,
    input {
        border: none;
        margin: 10px auto;
    }

    select.form-control,
    select {
        border: none;
        margin: 10px auto;
    }

    form .form-control {
        border-bottom: 1px solid #d4d4d4;
        color: #5a5a5a;
    }

    .second_card .row {
        margin: 30px auto;
        border-bottom: 0.1px solid #efefef;
    }
</style>
<link rel="stylesheet" type="text/css" href="files/assets/pages/j-pro/css/j-pro-modern.css" />

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <?
                                $siteid = $_REQUEST['siteid'];
                                if(isset($siteid) && !empty($siteid)){
                                    
                                    $sql = mysqli_query($con,"select * from sites where id='".$siteid."' and status=1");
                                    if($sql_result = mysqli_fetch_assoc($sql)){
                                        $atmid = $sql_result['atmid'];
                                        $atmid2 = $sql_result['atmid2'];
                                        $atmid3 = $sql_result['atmid3'];
                                        $address = $sql_result['address'];
                                        $city = $sql_result['city'];
                                        $state = $sql_result['state'];
                                        $lho = $sql_result['LHO'];
                                    }
                                    
                                }
                                
                                
                                
                                ?>

                    <h3>Feasibility Check</h3>
                    <form id="myForm" enctype="multipart/form-data">
                        <input type="hidden" name="userid" value="<? echo $userid; ?>" />
                        <!--<form method="POST" action="./API/feasibilitycheck.php" enctype="multipart/form-data" >-->

                        <div class="card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Number of ATM Available</label>
                                        <select class="form-control" name="noOfAtm" id="noOfAtm" required>
                                            <option value="">Select</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Feasibility Done</label>
                                        <select class="form-control" name="feasibilityDone" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>ATMID 1</label>
                                        <input type="text" id="ATMID1" name="ATMID1" class="form-control" value="<? echo $atmid; ?>"
                                        <? if($atmid) { echo 'readonly'; } ?>
                                        required /> ATMID1 Snap<input type="file" name="ATMID1Snap" required />
                                    </div>
                                    <div class="col-sm-4">
                                        <label>ATMID 2</label>
                                        <input type="text" name="ATMID2" class="form-control" value="<? echo $atmid2; ?>" />
                                        ATMID2 Snap<input type="file" name="ATMID2Snap" />
                                    </div>
                                    <div class="col-sm-4">
                                        <label>ATMID 3</label>
                                        <input type="text" name="ATMID3" class="form-control" value="<? echo $atmid3; ?>" />
                                        ATMID3 Snap<input type="file" name="ATMID3Snap" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>City</label>
                                        <input type="text" id="city" name="city" class="form-control" value="<? echo $city; ?>"
                                        <? if($atmid) { echo 'readonly'; } ?>
                                        required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Location</label>
                                        <input type="text" id="location" name="location" class="form-control" value="<? echo $address; ?>"
                                        <? if($atmid) { echo 'readonly'; } ?>
                                        required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>LHO</label>
                                        <input type="text" id="LHO" name="LHO" class="form-control" value="<? echo $lho; ?>"
                                        <? if($atmid) { echo 'readonly'; } ?>
                                        required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>State</label>
                                        <input type="text" id="state" name="state" class="form-control" value="<? echo $state; ?>"
                                        <? if($atmid) { echo 'readonly'; } ?>
                                        required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Address</label>
                                        <input type="text" id="address" name="address" class="form-control" value="<? echo $address; ?>"
                                        <? if($atmid) { echo 'readonly'; } ?>
                                        required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label id="atm1StatusLabel" style="display: none;">ATMID 1 Working</label>
                                        <select class="form-control atm-status" name="atm1Status" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label id="atm2StatusLabel" style="display: none;">ATMID 2 Working</label>
                                        <select class="form-control atm-status" name="atm2Status">
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label id="atm3StatusLabel" style="display: none;">ATMID 3 Working</label>
                                        <select class="form-control atm-status" name="atm3Status">
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card second_card">
                            <div class="card-block">
                                <div class="row">
                                    <h6 class="col-sm-3">Network available in back room</h6>
                                    <div class="col-sm-2">
                                        <label>Operator 1</label>
                                        <select name="operator" class="form-control" required>
                                            <option value="">Select</option>
                                            <option>Airtel</option>
                                            <option>Vodafone</option>
                                            <option>Jio</option>
                                            <option>Any Other</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Status of Signal</label>
                                        <input name="signalStatus" type="text" class="form-control" required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Remark</label>
                                        <input name="backroomNetworkRemark" type="text" class="form-control" required />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Snapshot</label>
                                        <input name="backroomNetworkSnap" type="file" required />
                                    </div>

                                    <h6 class="col-sm-3"></h6>
                                    <div class="col-sm-2">
                                        <label>Operator 2</label>
                                        <select name="operator2" class="form-control" required>
                                            <option value="">Select</option>
                                            <option>Airtel</option>
                                            <option>Vodafone</option>
                                            <option>Jio</option>
                                            <option>Any Other</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Status of Signal</label>
                                        <input name="signalStatus2" type="text" class="form-control" required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Remark</label>
                                        <input name="backroomNetworkRemark2" type="text" class="form-control" required />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Snapshot</label>
                                        <input name="backroomNetworkSnap2" type="file" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <h6 class="col-sm-3">Back Room Key</h6>
                                    <div class="col-sm-3">
                                        <label>Status</label>
                                        <select name="backroomKeyStatus" class="form-control" required>
                                            <option value="">Select</option>
                                            <option>Available with LL</option>
                                            <option>Available with HK Person</option>
                                            <option>Available with MSP </option>
                                            <option>Available with Bank</option>
                                            <option>Any Other</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Backroom Contact Person Name</label>
                                        <input name="backroomKeyName" type="text" class="form-control" required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Backroom Contact Person Number</label>
                                        <input name="backroomKeyNumber" type="text" class="form-control" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <h6 class="col-sm-3">EM lock Available</h6>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="EMlockAvailable" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>EM lock Access</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Password Received</label>
                                        <select class="form-control" name="PasswordReceived" onchange="togglePasswordField(this)" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3" id="emLockPasswordField" style="display: none;">
                                        <label>EM Lock Password</label>
                                        <input type="text" name="EMLockPassword" class="form-control" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Place to fix Router Antenna</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="routerAntenaPosition" required>
                                            <option value="">Select</option>
                                            <option>Above Ceiling</option>
                                            <option>In ATM lobby</option>
                                            <option>Out Side the lobby</option>
                                            <option>Any Other</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="routerAntenaSnap" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Antenna Wire Routing detail</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="AntennaRoutingdetail" class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="AntennaRoutingSnap" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>UPS Available</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="UPSAvailable" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="UPSAvailableSnap" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>No. of UPS</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="NoOfUps" id="noOfUpsSelect" required>
                                            <option value="">Select</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="NoOfUpsSnap" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>UPS Working</h6>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="UPSWorking1" id="upsWorking1Select" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>NO</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="UPSWorking2" id="upsWorking2Select" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>NO</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="UPSWorking3" id="upsWorking3Select" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>NO</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="upsWorkingSnap" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>UPS Battery Backup</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="UPSBateryBackup" class="form-control" placeholder="Hrs ..." />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Power Socket Available for Router in DB</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="powerSocketAvailability" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="powerSocketAvailabilitySnap" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Power Socket Available for Router in UPS</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="powerSocketAvailabilityUPS" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="powerSocketAvailabilityUPSSnap" required />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Unwanted material in back room which bars access for working</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="backroomDisturbingMaterial" onchange="toggleFields2(this)">
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3" id="backroomRemarkContainer" style="display: none;">
                                        <input type="text" name="backroomDisturbingMaterialRemark" class="form-control" placeholder="Remarks ... " />
                                    </div>
                                    <div class="col-sm-3" id="backroomSnapContainer" style="display: none;">
                                        <input type="file" name="backroomDisturbingMaterialSnap" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Earthing</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="earthing">
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="earthingVltg" class="form-control" placeholder="EN Vtg ... " />
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="earthingSnap" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Power Fluctuation</h6>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="powerFluctuationPE" placeholder="PE vtg.." />
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="powerFluctuationPN" placeholder="PN vtg.." />
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="powerFluctuationEN" placeholder="EN vtg.." />
                                    </div>

                                    <div class="col-sm-3">
                                        <input type="file" name="powerFluctuationSnap" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Frequent Power cut</h6>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="frequentPowerCut" class="form-control" onchange="toggleFields(this)">
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2" id="powerCutFromContainer" style="display: none;">
                                        <input type="text" class="form-control" name="frequentPowerCutFrom" placeholder="Frequent Power Cut From" />
                                    </div>
                                    <div class="col-sm-2" id="powerCutToContainer" style="display: none;">
                                        <input type="text" class="form-control" name="frequentPowerCutTo" placeholder="To" />
                                    </div>
                                    <div class="col-sm-3" id="powerCutRemarkContainer" style="display: none;">
                                        <input type="text" class="form-control" name="frequentPowerCutRemark" class="form-control" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Nearest Hadware or Electric Shop</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="nearestShopDistance" placeholder="Distance From ATM " />
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="nearestShopName" placeholder="Name ..." />
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="nearestShopNumber" placeholder="Number ..." />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Any Other Remark</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="Remarks" class="form-control" placeholder="Remarks ... " />
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="file" name="remarksSnap" />
                                    </div>
                                </div>

                                <br />
                                <button type="submit" id="submitButton" class="btn btn-success" onclick="saveForm()">Save</button>

                                <!--<input type="submit" name="submit" class="btn btn-success" />-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".atm-status").hide();
        $("#noOfAtm").on("change", function () {
            var noOfAtm = $(this).val();
            $(".atm-status").hide();
            $(".atm-status").prev("label").hide();
            for (var i = 1; i <= noOfAtm; i++) {
                $("select[name='atm" + i + "Status']").show();
                $("label#atmId" + i + "Label").show();
                $("label#atm" + i + "StatusLabel").show();
            }
        });

        $("#noOfUpsSelect").change(function () {
            var noOfUps = $(this).val();
            // Show/hide UPSWorking fields based on selected NoOfUps
            $("#upsWorking1Select").toggle(noOfUps >= 1);
            $("#upsWorking2Select").toggle(noOfUps >= 2);
            $("#upsWorking3Select").toggle(noOfUps >= 3);

            $("#upsWorking1Select").prop("required", noOfUps >= 1);
            $("#upsWorking2Select").prop("required", noOfUps >= 2);
            $("#upsWorking3Select").prop("required", noOfUps >= 3);
        });
    });

    $(document).ready(function () {
        // Function to populate form fields

        function populateFormFields(data) {
            if (data) {
                $("#address").prop("readonly", true);
                $("#city").prop("readonly", true);
                $("#location").prop("readonly", true);
                $("#LHO").prop("readonly", true);
                $("#state").prop("readonly", true);

                $("#address").val(data.address);
                $("#city").val(data.city);
                $("#location").val(data.location);
                $("#LHO").val(data.lho);
                $("#state").val(data.state);
            } else {
                $("#address").prop("readonly", false);
                $("#city").prop("readonly", false);
                $("#location").prop("readonly", false);
                $("#LHO").prop("readonly", false);
                $("#state").prop("readonly", false);

                $("#address").val("");
                $("#city").val("");
                $("#location").val("");
                $("#LHO").val("");
                $("#state").val("");
            }
        }

        // Event listener for change in ATMID1
        $("#ATMID1").change(function () {
            var atmID = $(this).val();
            if (atmID !== "") {
                // AJAX request to fetch ATM details
                $.ajax({
                    url: "https://sarmicrosystems.in/advantage/API/getATMIDInfo.php?ATMID1=" + atmID,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        $("#address").val("");
                        $("#city").val("");
                        $("#location").val("");
                        $("#LHO").val("");
                        $("#state").val("");

                        if (response.code === 200) {
                            populateFormFields(response); // Populate form fields with response data
                        } else if (response.code === 300) {
                            populateFormFields(response);
                            swal("Error", "ATMID Not found !", "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert("An error occurred while fetching ATM details. Please try again.");
                    },
                });
            } else {
                // Clear form fields if ATMID1 is empty
                $("#address").val("");
                $("#city").val("");
                $("#location").val("");
                $("#LHO").val("");
                $("#state").val("");
            }
        });
    });

    function toggleFields2(selectElement) {
        var backroomRemarkContainer = document.getElementById("backroomRemarkContainer");
        var backroomSnapContainer = document.getElementById("backroomSnapContainer");

        if (selectElement.value === "Yes") {
            backroomRemarkContainer.style.display = "block";
            backroomSnapContainer.style.display = "block";
        } else {
            backroomRemarkContainer.style.display = "none";
            backroomSnapContainer.style.display = "none";
        }
    }

    function togglePasswordField(selectElement) {
        var emLockPasswordField = document.getElementById("emLockPasswordField");

        if (selectElement.value === "Yes") {
            emLockPasswordField.style.display = "block";
        } else {
            emLockPasswordField.style.display = "none";
        }
    }

    function toggleFields(selectElement) {
        var powerCutFromContainer = document.getElementById("powerCutFromContainer");
        var powerCutToContainer = document.getElementById("powerCutToContainer");
        var powerCutRemarkContainer = document.getElementById("powerCutRemarkContainer");

        if (selectElement.value === "Yes") {
            powerCutFromContainer.style.display = "block";
            powerCutToContainer.style.display = "block";
            powerCutRemarkContainer.style.display = "block";
        } else {
            powerCutFromContainer.style.display = "none";
            powerCutToContainer.style.display = "none";
            powerCutRemarkContainer.style.display = "none";
        }
    }

    function saveForm() {
        event.preventDefault();

        document.getElementById("submitButton").disabled = true;

        var formData = new FormData($("#myForm")[0]);
        var requiredFields = $("#myForm :required");
        var emptyFields = [];

        // Check for empty required fields
        requiredFields.each(function () {
            if ($(this).val() === "") {
                emptyFields.push($(this).attr("name"));
            }
        });

        if (emptyFields.length > 0) {
            swal("Error", "Please fill in all the required fields!", "error");
            $("input, select").removeClass("highlight");
            $.each(emptyFields, function (index, fieldName) {
                $('[name="' + fieldName + '"]').addClass("highlight");
            });
            return; // Exit the function if empty fields exist
        }

        $.ajax({
            url: "API/feasibilitycheck.php",
            type: "POST",
            data: formData,
            contentType: false, // Important: Set contentType to false for file uploads
            processData: false, // Important: Disable processing of the data
            success: function (response) {
                if (response.code === 200) {
                    swal("Success", "Added Successfully!", "success");

                    location.reload();
                    // Example: Reload the page
                    // Reset form fields
                    // $('input[type="text"]').val('');
                    // $('select').val('');
                } else {
                    alert("Added Error!");
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                alert("Added Error!");
            },
        });
    }
</script>

<? include('footer.php'); ?>
