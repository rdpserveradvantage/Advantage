<? include('config.php');

$sql = mysqli_query($con,"SELECT * from material_send");
while($sql_result = mysqli_fetch_assoc($sql)){

    $siteid = $sql_result['siteid'];

    $lho = mysqli_fetch_assoc(mysqli_query($con,"select LHO from sites where id='".$siteid."'"))['LHO'];
    mysqli_query($con,"update material_send set lho='".$lho."' where siteid='".$siteid."'");
}

?>