<? include('config.php');
$siteId = $_REQUEST['siteId'];


?>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Sr No</th>
            <th>ATMID</th>
            <th>Portal</th>
            <th>Event</th>
            <th>Description</th>
            <th>Datetime</th>
        </tr>
    </thead>
    <tbody>
<?  
$i=1 ; 

$sql = mysqli_query($con,"select * from event_log where site_id='".$siteId."'");
while($sql_result = mysqli_fetch_assoc($sql)){

$atmid = $sql_result['atmid'];
$portal = $sql_result['portal'];
$event = $sql_result['event_name'];
$description = $sql_result['event_description'];
$created_at = $sql_result['event_timestamp'];
?>  
    <tr>
        <td><? echo $i; ?></td>
        <td><? echo $atmid; ?></td>
        <td><? echo $portal; ?></td>
        <td><? echo $event; ?></td>
        <td><? echo $description; ?></td>
        <td><? echo $created_at; ?></td>
    </tr>
    
<? $i++; } ?>
</tbody>
</table>
