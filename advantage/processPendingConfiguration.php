<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include('config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $atmid = $_POST['atmid'];
        $serialNumber = $_POST['serialNumber'];
        $sealNumber = $_POST['sealNumber'];
        $sealNumber ? $sealNumber : 'NA';

        $networkIP = $_POST['networkIP'];
        $routerIP = $_POST['routerIP'];
        $atmIP = $_POST['atmIP'];
        // Check if ATM ID exists in the "sites" table
        $checkQuery = mysqli_query($con, "SELECT * FROM sites WHERE atmid = '" . $atmid . "'");
        if ($checkQueryResult = mysqli_fetch_assoc($checkQuery)) {

            $checksql = mysqli_query($con, "select * from routerConfiguration where atmid='" . $atmid . "' and status=1");
            if ($checksqlResult = mysqli_fetch_assoc($checksql)) {
                echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error: Already Configured",
                    confirmButtonText: "Okay"
                }).then((result) => {
                      window.location.href = "pendingConfiguration1.php";
                    
                  });
            </script>';
            
            } else {
                $insertQuery = "INSERT INTO routerConfiguration (atmid, serialNumber, sealNumber, status, created_at, created_by)
            VALUES ('" . $atmid . "', '" . $serialNumber . "', '" . $sealNumber . "', '1', '" . $datetime . "', '" . $userid . "')";

                mysqli_query($con, "update sites set networkIP = '" . $networkIP . "', routerIP = '" . $routerIP . "', atmIP = '" . $atmIP . "' where atmid='" . $atmid . "'");

                try {
                    mysqli_query($con, $insertQuery);

                    // Data inserted successfully, display a success message using Swal 2
                    echo '<script>
    Swal.fire({
        icon: "success",
        title: "Success",
        text: "Data Recorded successfully!",
        confirmButtonText: "Okay" // Change button text
    }).then(function () {
        // Redirect to pendingConfiguration.php
        window.location.href = "pendingConfiguration1.php";
    });
</script>';
                } catch (PDOException $e) {
                    // Error occurred, display an error message using Swal 2
                    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Error",
        text: "Error: ' . $e->getMessage() . '",
        confirmButtonText: "Okay" // Change button text
    });
</script>';
                }
            }
        } else {
            // ATM ID does not exist in the 'sites' table
            echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "ATM ID does not exist in the \'sites\' table.",
                confirmButtonText: "Okay" // Change button text
            });
        </script>';
        }
    } else {
        echo "Invalid request method.";
    }
    ?>

</body>

</html>