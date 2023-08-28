<? session_start();
include('config.php');

$vendorId = $_REQUEST['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>IFrame Example</title>
</head>
<body>
 <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
    
    <?
$advantagetoken = $_SESSION['advantagetoken'];
    ?>
    
    <iframe src="https://sarmicrosystems.in/RailTelVendor/index.php?access=superadmin&vendor=<? echo $vendorId;?>&advantagetoken=<? echo $advantagetoken; ?>" width="100%" height="100vh" frameborder="0"></iframe>
</body>
</html>
