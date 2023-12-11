<?php
include('config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$query = "select * from boq where status=1 and value='Router'";
$result = mysqli_query($con, $query);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $materialName[] = trim($row['value']);
}

$qty = array(); // Initialize the $qty array

foreach ($materialName as $materialNameKey => $materialNameValue) {
    $quantitySql = mysqli_query($con, "select count(1) as count from inventory where material='" . trim($materialNameValue) . "'");
    $quantitySqlResult = mysqli_fetch_assoc($quantitySql);
    $qty[] = $quantitySqlResult['count'];
}

$vendorNames = array();
$vendorQuery = mysqli_query($con, "select DISTINCT(vendorName) as vendorName,id from vendor where status=1");
while ($vendorRow = mysqli_fetch_assoc($vendorQuery)) {
    $vendorNames[] = $vendorRow['vendorName'];
    $vendorIds[] = $vendorRow['id'];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Information</title>
    
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <table class="table table-striped table-hover">
        <tr>
            <th colspan="2">Material with Counts</th>
            <th colspan="<?= count($vendorNames); ?>">Stock assigned to Vendors</th>
            <th colspan="<?= count($vendorNames); ?>">Live Sites</th>
            <th colspan="<?= count($vendorNames); ?>">Stock with Vendors</th>
            <th colspan="2">Balance Stock with Advantage</th>
        </tr>

        <tr>
            <th>Material</th>
            <th>Count</th>
            <?php
            foreach ($vendorNames as $vendorName) { ?>
                <th>
                    <?= $vendorName; ?>
                </th>
            <?php } ?>
            <?php
            foreach ($vendorNames as $vendorName) { ?>
                <th>
                    <?= $vendorName; ?>
                </th>

            <?php } ?>
            <?php

            foreach ($vendorNames as $vendorName) { ?>
                <th>
                    <?= $vendorName; ?>
                </th>
            <?php } ?>

            <th>Assigned</th>
            <th>Un-Assigned</th>
        </tr>

        <?php for ($i = 0; $i < count($materialName); $i++): ?>
            <tr>
                <td class="strong">
                    <?php echo $materialName[$i]; ?>
                </td>
                <td>
                    <?php echo $qty[$i]; ?>
                </td>


                <?php

                foreach ($vendorIds as $vendorId => $vendorKey): ?>
                    <?php

                    $matCountSql = "SELECT COUNT(1) as assignedCount FROM vendorinventory WHERE material='" . trim($materialName[$i]) . "' AND vendorId=$vendorKey";

                    $assignedCountSql = mysqli_query($con, $matCountSql);
                    $assignedCountResult = mysqli_fetch_assoc($assignedCountSql);
                    $assignedCount = $assignedCountResult['assignedCount'];
                    $unassignedCount = 0 . 'ds';
                    ?>
                    <td>
                        <?= $assignedCount; ?>
                    </td>
                    <?php

                endforeach; ?>


                <?php

                foreach ($vendorIds as $vendorId => $vendorKey): ?>
                    <?php
echo 
                    $matCountSql = "SELECT COUNT(1) as assignedCount FROM vendorinventory WHERE material='" . trim($materialName[$i]) . "' AND vendorId=$vendorKey";

                    $assignedCountSql = mysqli_query($con, $matCountSql);
                    $assignedCountResult = mysqli_fetch_assoc($assignedCountSql);
                    $assignedCount = $assignedCountResult['assignedCount'];
                    ?>
                    <td>
                        <? 
                        // $assignedCount; 
                        ?>
                    </td>
                    <?php

                endforeach; ?>





            </tr>
        <?php endfor; ?>

    </table>

</body>

</html>