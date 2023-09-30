<? include('header.php'); ?>


<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
                            <form action="<? $_SERVER['PHP_SELF']; ?>" method="post">
                                <table border="1">
                                    <tr>
                                        <th>Select</th>
                                        <th>Material Name</th>
                                        <th>Serial Number / Quantity</th>
                                    </tr>
                                    <?php

                                    // Fetch materials from the BOQ table
                                    $sql = "SELECT id, value, needSerialNumber FROM boq ORDER BY needSerialNumber DESC";
                                    $result = $con->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id'];
                                            $materialName = $row['value'];
                                            $hasSerialNumber = $row['needSerialNumber'];

                                            echo "<tr>";
                                            // echo "<td><input type='checkbox' name='selected_materials[]' value='$id' onchange='handleCheckboxChange($id, this)'></td>";
                                            echo "<td><input type='checkbox' name='selected_materials[]' value='$id' onchange='handleCheckboxChange($id, this)' id='checkbox$id'></td>";
                                            echo "<td>$materialName</td>";

                                            echo "<td>";
                                            if ($hasSerialNumber == 1) {
                                                echo "<div id='serialNumberInputs$id'>";
                                                echo "<div class='serialInput'>";
                                                echo "<input type='text' name='serial_numbers[$id][]' placeholder='Serial Number' disabled>";
                                                echo "<button type='button' onclick='addSerialNumberInput($id)' disabled>Add</button>";
                                                echo "</div>";
                                                echo "</div>";
                                            } else {
                                                // For materials that don't require serial numbers, use an empty div as a placeholder.
                                                echo "<div id='serialNumberInputs$id'></div>";
                                                echo "<input type='number' name='quantities[$id]' id='quantityInput$id' placeholder='Quantity' disabled>";
                                            }
                                            echo "</td>";

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No materials found in the BOQ.</td></tr>";
                                    }

                                    // Close the database connection
                                    $con->close();
                                    ?>
                                </table>

                                <br>
                                <input type="submit" value="Send Selected Materials to OEM">
                            </form>
                            <script>
                                function toggleSerialInputs(materialId, checked) {
                                    var container = document.getElementById("serialNumberInputs" + materialId);
                                    var inputs = container.getElementsByTagName("input");
                                    var buttons = container.getElementsByTagName("button");

                                    if (container) {
                                        for (var i = 0; i < inputs.length; i++) {
                                            inputs[i].disabled = !checked;
                                            inputs[i].required = checked;
                                            // Set the minimum value of the input to 1 if the checkbox is checked
                                            inputs[i].min = checked ? 1 : 0;
                                        }

                                        for (var j = 0; j < buttons.length; j++) {
                                            buttons[j].disabled = !checked;
                                        }

                                    }

                                    // Enable/disable quantity input based on checkbox state
                                    var quantityInput = document.getElementById("quantityInput" + materialId);
                                    if (quantityInput) {
                                        quantityInput.disabled = !checked;
                                        if (!checked) {
                                            quantityInput.value = ""; // Clear quantity input if checkbox is unchecked
                                        }
                                        // Set the minimum value of the quantity input to 1 if the checkbox is checked
                                        quantityInput.min = checked ? 1 : 0;
                                    }
                                }

                                function handleCheckboxChange(materialId, checkbox) {
                                    toggleSerialInputs(materialId, checkbox.checked);
                                }

                                function addSerialNumberInput(materialId) {
                                    var container = document.getElementById("serialNumberInputs" + materialId);

                                    // Create a div to group the input and remove button
                                    var divWrapper = document.createElement("div");

                                    var input = document.createElement("input");
                                    input.type = "text";
                                    input.name = "serial_numbers[" + materialId + "][]";
                                    input.placeholder = "Serial Number";
                                    input.required = true; // Make the added serial number input required

                                    var removeButton = document.createElement("button");
                                    removeButton.type = "button";
                                    removeButton.textContent = "Remove";
                                    removeButton.addEventListener("click", function() {
                                        // Remove the div wrapper, which contains the input and remove button
                                        container.removeChild(divWrapper);
                                    });

                                    // Append the input and remove button to the div wrapper
                                    divWrapper.appendChild(input);
                                    divWrapper.appendChild(removeButton);

                                    // Append the div wrapper to the container
                                    container.appendChild(divWrapper);
                                }
                            </script>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


<? include('footer.php'); ?>