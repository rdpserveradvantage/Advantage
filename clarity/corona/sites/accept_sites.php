<? include('../config.php');

$checkedIds = $_REQUEST['checkedIds'] ; 

foreach ($checkedIds as $key => $id) {
    

    $sql = mysqli_query($con,"select * from lhositesdelegation where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql); 
    $siteid = $sql_result['siteid'];


    





}




?>