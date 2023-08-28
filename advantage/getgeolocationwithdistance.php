<!DOCTYPE html>
<html>
<head>
    <title>Geolocation Example</title>
    <script>
        // Function to retrieve geolocation
        function getGeolocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        // Success callback function
        function successCallback(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Assign values to hidden input fields
            document.getElementById("latitudeInput").value = latitude;
            document.getElementById("longitudeInput").value = longitude;

            // Submit the form
            document.getElementById("geolocationForm").submit();
        }

        // Error callback function
        function errorCallback(error) {
            console.log("Error retrieving geolocation:", error);
        }
    </script>
</head>
<body>
    <?php
    // Function to calculate the distance between two sets of coordinates using the Haversine formula
    function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
        $earthRadius = 6371; // Radius of the Earth in kilometers

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // Distance in kilometers

        return $distance;
    }

    // Process the submitted form data
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $latitude = $_POST["latitude"];
        $longitude = $_POST["longitude"];

        // Given coordinates
        $givenLatitude = 19.109256;
        $givenLongitude = 73.012946;
         

        // Calculate the distance
        $distance = calculateDistance($latitude, $longitude, $givenLatitude, $givenLongitude);

        // Format the distance for display
        $formattedDistance = number_format($distance, 2);

        // Display the retrieved values and the calculated distance
        echo "<h2>Retrieved Geolocation:</h2>";
        echo "<p>Latitude: " . $latitude . "</p>";
        echo "<p>Longitude: " . $longitude . "</p>";
        echo "<h2>Distance:</h2>";
        echo "<p>" . $formattedDistance . " km</p>";
        $meterDistance = $formattedDistance*1000;
        
        echo $meterDistance . ' Meters' ; 
    }
    ?>

    <h1>Geolocation Example</h1>

    <form id="geolocationForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" id="latitudeInput" name="latitude" value="">
        <input type="hidden" id="longitudeInput" name="longitude" value="">
        <button type="button" onclick="getGeolocation()">Get Geolocation</button>
    </form>
</body>
</html>
