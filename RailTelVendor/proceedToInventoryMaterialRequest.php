<?php include('config.php');

$id = $_REQUEST['id'];

if ($id > 0) {

    $sql = "update vendormaterialrequest set status=0,requestToInventory=1,requestToInventoryBy='" . $userid . "',requestToInventoryDate='" . $datetime . "' where id='" . $id . "'";
    if (mysqli_query($con, $sql)) {
    echo 1;
    }else{
        echo 0;
    }
}else{
    echo 0;
}
