<? include('header.php'); ?>

<style>
    .showsubmenu{
        margin: 0.4% 3%;        
    }

</style>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <?

                                        $userid = $_GET['id']; 
                                        $usersql = mysqli_query($con,"select * from vendorUsers where id='".$userid."'");
                                        $usersql_result = mysqli_fetch_assoc($usersql);
                                        $user_permission = $usersql_result['permission'];
                                        $user_permission = explode (",", $user_permission);
                                        
                                        $serviceuser_permission = $usersql_result['servicePermission'];
                                        $serviceuser_permission = explode (",", $serviceuser_permission);
                                        
                                        $level = $_REQUEST['level'];
                                        
                                        if(isset($_POST['submit'])){                                        
                                        $permission =$_POST['sub_menu'];
                                        $permission = implode(',',$permission);

                                        

                                         $sql = "update vendorUsers set permission='".$permission."' where id='".$userid."'"; 
                                         
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('Updated !');
                                                 window.location.href="allotmenu_perm.php?id=<? echo $userid;?>";
                                             </script>
                                        <?      }else{ ?>
                                           <script>
                                                 alert('Error ! ');
                                                 window.location.href="allotmenu_perm.php?id=<? echo $userid;?>";
                                             </script> 
                                        <? }
                                            }
                                        if(isset($_POST['service'])){
                                            
                                            
                                            
                                        $permission =$_POST['sub_menu'];
                                        $permission = implode(',',$permission);
                                        $sql = "update vendorUsers set servicePermission='".$permission."' where id='".$userid."'"; 
                                         
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('Updated !');
                                                 window.location.href="allotmenu_perm.php?id=<? echo $userid;?>";
                                             </script>
                                        <?      }else{ ?>
                                           <script>
                                                 alert('Error ! ');
                                                 window.location.href="allotmenu_perm.php?id=<? echo $userid;?>";
                                             </script> 
                                        <? }
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                        }
                                        ?>
                                        
                                        
                                        
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h5>Project</h5>
                                                <hr />
                                                <form action="<? echo $_SERVER['PHP_SELF'];?>?id=<? echo $userid?>" method="POST">
                                            <ul>
                                            <?
                                            
                                            $mainsql = mysqli_query($con,"select * from main_menu where vendorStatus=1");
                                            while($mainsql_result = mysqli_fetch_assoc($mainsql)){
                                            $main_id = $mainsql_result['id'];
                                            ?>
                                                
                                              
                                                  <li>
                                                     <input type="checkbox" class="main_menu" value="<? echo $main_id;?>"> <? echo $mainsql_result['name'];?>   
                                                  
                                              
                                                <!--<br>-->
                                                
                                                <ul class="showsubmenu">
                                                        
                                                        <? $sub_sql = mysqli_query($con,"select * from sub_menu where main_menu='".$main_id."' and vendorStatus=1");
                                                        while($sub_sql_result = mysqli_fetch_assoc($sub_sql)){
                                                        $sub_id = $sub_sql_result['id'];
                                                        ?>
                                                            
                                                    <li>
                                                            <input class="submenu" type="checkbox" data-main_id="<? echo $main_id?>" name="sub_menu[]" value="<? echo $sub_id; ?>" <? if(in_array($sub_id,$user_permission)){ echo 'checked' ; } ?> > <? echo $sub_sql_result['sub_menu'];?>
                                                    </li>
                                                            
                                                            <!--<br>-->
                                                        <? } ?>
                                                </ul>
                                                </li>
                                            <? } ?>
                                            </ul>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <br>
                                                    <input type="submit" name="submit" class="btn btn-primary">                                                    
                                                </div>

                                                
                                            </div>
                                        </form>
                                            </div>
                                            
                                            
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
                                        
                                        
                                        
                                        <div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>

<script>

$(function () {
    $("input[type='checkbox']").change(function () {
        $(this).siblings('ul')
            .find("input[type='checkbox']")
            .prop('checked', this.checked);
    });
});

</script>
