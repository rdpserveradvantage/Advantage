<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                       
                                       
                                       
                                       <?
                                       $cities = $_POST['cities'];
                                       $userid = $_POST['userid'];
                                       
$cities=json_encode($cities);
$cities=str_replace( array('[',']','"') , ''  , $cities);
$arr=explode(',',$cities);
$cities = "" . implode ( ",", $arr )."";


$zone = $_POST['zone'];
$zone=json_encode($zone);
$zone=str_replace( array('[',']','"') , ''  , $zone);
$zone=explode(',',$zone);
$zone = "" . implode ( ",", $zone )."";

$cust_id = $_POST['cust_id'];
$cust_id=json_encode($cust_id);
$cust_id=str_replace( array('[',']','"') , ''  , $cust_id);
$cust_id=explode(',',$cust_id);
$cust_id = "" . implode ( ",", $cust_id )."";


 $statement = "update mis_loginusers set branch ='".$cities."', zone='".$zone."', cust_id='".$cust_id."' where id='".$userid."'" ;



if(mysqli_query($con,$statement)){ ?>
   <script>
       alert('Done !');
       window.location.href="permissions.php";
   </script>
   
<? }




                                       ?>
                                       
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                <div class="row">

    

<div class="col-sm-6">
    <h5>Service</h5>
    <hr />
    
    <form action="<? echo $_SERVER['PHP_SELF'];?>?id=<? echo $userid?>&portal=service" method="POST">
<ul>
<?

$mainsql = mysqli_query($con,"select * from main_menu where isService=1");
while($mainsql_result = mysqli_fetch_assoc($mainsql)){
$main_id = $mainsql_result['id'];
?>
<li>
    <input type="checkbox" class="main_menu" value="<?= $main_id;?>"> <?= $mainsql_result['name'];?>
    <ul class="showsubmenu">
    <?
        $sub_sql = mysqli_query($con,"select * from sub_menu where main_menu='".$main_id."' and isService=1");
        while($sub_sql_result = mysqli_fetch_assoc($sub_sql)){
        $sub_id = $sub_sql_result['id'];
    ?>
    <li>
        <input class="submenu" type="checkbox" data-main_id="<? echo $main_id?>" name="sub_menu[]" value="<? echo $sub_id; ?>" <? if(in_array($sub_id,$serviceuser_permission)){ echo 'checked' ; } ?> > <? echo $sub_sql_result['sub_menu'];?>
    </li>
    <? } ?>
    </ul>
    </li>
<? } ?>
</ul>

<div class="row">
    <div class="col-sm-12">
        <br>
        <input type="submit" name="service" class="btn btn-primary">                                                    
    </div>

    
</div>
</form>


</div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>
    
        <script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script src="../datatable/dataTables.buttons.min.js"></script>
<script src="../datatable/buttons.flash.min.js"></script>
<script src="../datatable/jszip.min.js"></script>




<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>



</body>

</html>