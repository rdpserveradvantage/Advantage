<? include('header.php'); ?>

<style>
    .showsubmenu{
        margin: 0.4% 3%;        
    }

</style>


<link rel="stylesheet" type="text/css" href="https://demo.dashboardpack.com/adminty-html/files/assets/icon/icofont/css/icofont.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                        
                                        <?
                                        $table = $_REQUEST['table'] ; 
                                        if(isset($table) && !empty($table)){
                                            $table ; 
                                        }else{
                                            $table = 'mis_loginusers' ;
                                        }
                                        
                                        
                                        


                                        $userid = $_GET['id']; 
                                        $usersql = mysqli_query($con,"select * from $table where id='".$userid."'");
                                        $usersql_result = mysqli_fetch_assoc($usersql);
                                        $user_permission = $usersql_result['permission'];
                                        $user_permission = explode (",", $user_permission);
                                        
                                        $level = $usersql_result['level'];

                                        if(isset($_POST['submit'])){
                                        $permission =$_POST['sub_menu'];
                                        $permission = implode(',',$permission);

                                        

                                         $sql = "update $table set permission='".$permission."' where id='".$userid."'"; 
                                         
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('Updated !');
                                                 window.location.href="add_user.php";
                                             </script>
                                        <?      }else{ ?>
                                           <script>
                                                 alert('Error ! ');
                                                 window.location.href="allotmenu_perm.php?id=<? echo $userid;?>&table=<? echo $table; ?>";
                                             </script> 
                                        <? }
                                            }
                                        ?>
                                        <form action="<? echo $_SERVER['PHP_SELF'];?>?id=<? echo $userid?>&table=<? echo $table; ?>" method="POST">
                                            <ul>
                                            <?
                                            
                                            if($table=='inventoryUsers'){
                                                $statusColumn = 'inventory';
                                            }else{
                                                $statusColumn = 'status' ;     
                                            }
                                            
                                            
                                            
                                            if($level==1){
                                                $mainsql = mysqli_query($con,"select * from main_menu where $statusColumn=1");
                                            }else{
                                                $mainsql = mysqli_query($con,"select * from main_menu where $statusColumn=1 and id<>1");
                                            }

                                            while($mainsql_result = mysqli_fetch_assoc($mainsql)){
                                            $main_id = $mainsql_result['id'];
                                            ?>
                                                
                                              
                                                  <li class="card-block">


                                                     <input type="checkbox" class="main_menu" value="<? echo $main_id;?>">
                                                     <span class="strong"><? echo $mainsql_result['name'];?></span>   
                                                  
                                              
                                                <!--<br>-->
                                                
                                                <ul class="showsubmenu">
                                                        
                                                        <? $sub_sql = mysqli_query($con,"select * from sub_menu where main_menu='".$main_id."' and $statusColumn=1");
                                                        while($sub_sql_result = mysqli_fetch_assoc($sub_sql)){
                                                        $sub_id = $sub_sql_result['id'];
                                                        ?>
                                                            
                                                    <li>
                                                            <input class="submenu" type="checkbox" data-main_id="<? echo $main_id?>" name="sub_menu[]" value="<? echo $sub_id; ?>" <? if(in_array($sub_id,$user_permission)){ echo 'checked' ; } ?> > <? echo $sub_sql_result['sub_menu'];?>
                                                    </li>
                                                            
                                                            <!--<br>-->
                                                        <? } ?>
                                                </ul>
                                                <hr />
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
