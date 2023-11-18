<? include('config.php');

$id = $_REQUEST['id'];

if(isset($id) && $id > 0 ){

    if(mysqli_query($con,"update goodreturn  set isAccept=1 where id='".$id."'")){
        echo 1 ; 
    }else{
        echo 0;
    }
}else{
    echo 0 ; 
}


?>