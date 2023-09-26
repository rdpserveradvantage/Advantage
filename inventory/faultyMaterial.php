<? include('config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Faulty Materials to OEM</title>
</head>
<body>
    <h1>Send Faulty Materials to OEM</h1>

    <form action="process_materials.php" method="post">
        <table border="1">
            <tr>
                <th>Select</th>
                <th>Material Name</th>
                <th>Has Serial Number</th>
            </tr>
            <?php

            // Fetch materials from the BOQ table
            $sql = "SELECT value, needSerialNumber FROM boq order by needSerialNumber desc";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $materialName = $row['value'];
                    $hasSerialNumber = ($row['needSerialNumber'] == 1) ? 'Yes' : 'No';

                    echo "<tr>";
                    echo "<td><input type='checkbox' name='selected_materials[]' value='$materialName'></td>";
                    echo "<td>$materialName</td>";
                    echo "<td>$hasSerialNumber</td>";
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
</body>
</html>
