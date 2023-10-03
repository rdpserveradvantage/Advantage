<? include('config.php');

$randomName = rand(132,344323) ; 
mysqli_query($con,"insert into test(name,created_at) values('".$randomName."','".$datetime."')");


?>