<?php include('header.php');

function getSitesInfo($siteid, $parameter)
{
    global $con;

    $sql = mysqli_query($con, "select $parameter from sites where id='" . $siteid . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
}

?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
                            <h5>Material Request</h5>
                            <hr />

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Srno</th>
                                        <th>ATMID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Request Generated Date</th>
                                        <th>Request Generated By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $siteid = $_REQUEST['siteid'];
                                    $sql = mysqli_query($con, "select * from material_requests where siteid='" . $siteid . "' and status='pending'");
                                    while ($sql_result = mysqli_fetch_assoc($sql)) {

                                        $siteid = $sql_result['siteid'];
                                        $atmid = getSitesInfo($siteid, 'atmid');
                                        $material_name = $sql_result['material_name'];
                                        $quantity = $sql_result['quantity'];
                                        $created_at = $sql_result['created_at'];
                                        $created_by = $sql_result['created_by'];
                                        $vendorId = $sql_result['vendorId'];
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $atmid; ?></td>
                                            <td><?php echo $material_name; ?></td>
                                            <td><?php echo $quantity; ?></td>
                                            <td><?php echo $created_at; ?></td>
                                            <td><?php echo getUsername($created_by, 0); ?></td>
                                        </tr>

                                    <?php
                                        $i++;
                                    } ?>
                                </tbody>
                            </table>
                            <hr />
                            
                            
                            <?
                            
                            $atmsql = mysqli_query($con,"select * from sites where atmid='".$atmid."'");
                            $atmsql_result = mysqli_fetch_assoc($atmsql);
                            $networkIP = $atmsql_result['networkIP'];
                            $routerIP = $atmsql_result['routerIP'];
                            $atmIP = $atmsql_result['atmIP'];
                            $subnetIP = $atmsql_result['subnetIP'];
                            
                           
                            echo '<div class="ipInfo" style="    display: flex;justify-content: space-between;">
                                    <p><strong>Network IP :</strong> ' . $networkIP . '</p>
                                    <p><strong>Router IP :</strong> ' . $routerIP . '</p>
                                    <p><strong>ATM IP :</strong> ' . $atmIP . '</p>
                                    <p><strong>Subnet :</strong> ' . $subnetIP . '</p>
                                </div>';
                            
                            
                            ?>
                            <hr>
                            <form id="attributeForm" action="confirmSendMaterialRequest.php" method="POST">
                                <input type="hidden" name="atmid" value="<? echo $atmid ; ?>" />
                                <input type="hidden" name="siteid" value="<? echo $siteid ; ?>" />
                                <input type="hidden" name="vendorId" value="<? echo $vendorId ; ?>" />
                                
                                <div id="attributeFields">
                                    <?php
                                    $sql = mysqli_query($con, "select * from material_requests where siteid='" . $siteid . "' and status='pending'");
                                    while ($sql_result = mysqli_fetch_assoc($sql)) {
                                        $material_name = $sql_result['material_name'];
                                    ?>
                                        <div class="attribute-field">
                                            <input type="text" name="attribute[]" value="<?php echo $material_name; ?>">
                                            <input type="text" name="value[]" placeholder="Value" required>
                                            <select name="serialNumber[]" class="serial-number-list" disabled></select>
                                            <button class="remove-field" onclick="removeAttributeField(event)">Remove</button>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <button type="button" onclick="addAttributeField()">Add Attribute</button>
                                <button type="submit" onclick="validateForm(event)">Submit</button>
                            </form>

                            <script>
                                function addAttributeField() {
                                    var attributeFields = document.getElementById('attributeFields');
                                    var attributeField = document.createElement('div');
                                    attributeField.className = 'attribute-field';
                                    attributeField.innerHTML = `
                                      <input type="text" name="attribute[]" value="">
                                      <input type="text" name="value[]" placeholder="Value" required>
                                      <select name="serialNumber[]" class="serial-number-list" disabled></select>
                                      <button class="remove-field" onclick="removeAttributeField(event)">Remove</button>
                                    `;
                                    attributeFields.appendChild(attributeField);
                                }

                                function removeAttributeField(event) {
                                    var attributeField = event.target.parentNode;
                                    attributeField.remove();
                                }

                                function fetchSerialNumbers(materialInput, valueInput, serialNumberList) {
                                    var material = materialInput.value;
                                    var value = valueInput.value;

                                    var xhr = new XMLHttpRequest();
                                    xhr.open('GET', 'search_serial_number.php?material=' + encodeURIComponent(material) + '&value=' + encodeURIComponent(value));
                                    xhr.onload = function() {
                                        if (xhr.status === 200) {
                                            var serialNumbers = JSON.parse(xhr.responseText);

                                            serialNumberList.innerHTML = '';
                                            if (serialNumbers && serialNumbers.length > 0) {
                                                for (var i = 0; i < serialNumbers.length; i++) {
                                                    var option = document.createElement('option');
                                                    option.value = serialNumbers[i];
                                                    option.text = serialNumbers[i];
                                                    serialNumberList.appendChild(option);
                                                }
                                                serialNumberList.disabled = false;

                                                // Update value input with selected option
                                                serialNumberList.addEventListener('change', function() {
                                                    valueInput.value = this.value;
                                                });
                                            } else {
                                                serialNumberList.disabled = true;
                                            }
                                        } else {
                                            console.error(xhr.responseText);
                                        }
                                    };
                                    xhr.send();
                                }

                                function validateForm(event) {
                                    var valueInputs = document.getElementsByName('value[]');
                                    var serialNumberLists = document.getElementsByClassName('serial-number-list');
                                    var selectedSerialNumbers = [];

                                    for (var i = 0; i < serialNumberLists.length; i++) {
                                        var serialNumberList = serialNumberLists[i];
                                        if (!serialNumberList.disabled) {
                                            var selectedSerialNumber = serialNumberList.value;
                                            if (selectedSerialNumbers.includes(selectedSerialNumber)) {
                                                event.preventDefault();
                                                alert('Serial number ' + selectedSerialNumber + ' has already been selected.');
                                                return;
                                            }
                                            selectedSerialNumbers.push(selectedSerialNumber);
                                        }
                                    }

                                    var isValid = false;
                                    for (var i = 0; i < valueInputs.length; i++) {
                                        if (valueInputs[i].value !== '') {
                                            isValid = true;
                                            break;
                                        }
                                    }

                                    if (!isValid) {
                                        event.preventDefault();
                                        alert('Please fill in at least one value.');
                                    }
                                }

                                document.getElementById('attributeForm').addEventListener('submit', function(event) {
                                    event.preventDefault();

                                    var attributeInputs = document.getElementsByName('attribute[]');
                                    var valueInputs = document.getElementsByName('value[]');
                                    var serialNumberLists = document.getElementsByClassName('serial-number-list');

                                    for (var i = 0; i < valueInputs.length; i++) {
                                        var valueInput = valueInputs[i];
                                        var serialNumberList = serialNumberLists[i];
                                        var materialInput = valueInput.previousElementSibling;

                                        fetchSerialNumbers(materialInput, valueInput, serialNumberList);
                                    }

                                    this.submit();
                                });

                                var attributeFields = document.getElementById('attributeFields');
                                attributeFields.addEventListener('input', function(event) {
                                    var target = event.target;
                                    if (target.tagName === 'INPUT' && target.name === 'value[]') {
                                        var materialInput = target.previousElementSibling;
                                        var serialNumberList = target.nextElementSibling;
                                        fetchSerialNumbers(materialInput, target, serialNumberList);
                                    }
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<? include('footer.php'); ?>
