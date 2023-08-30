<? 
// include('config.php');
if($_SESSION['username']){ 
    $id = $_SESSION['userid'];

     $user = "select * from inventoryUsers where id=".$id;
    $usersql = mysqli_query($con,$user);
    $usersql_result = mysqli_fetch_assoc($usersql);
    
    $permission = $usersql_result['permission'];
    $permission = explode(',',$permission);
    sort($permission);

$cpermission=json_encode($permission);
$cpermission=str_replace( array('[',']','"') , ''  , $cpermission);
$cpermission=explode(',',$cpermission);
$cpermission = "'" . implode ( "', '", $cpermission )."'";


    $mainmenu = [];
   //  echo '<pre>';print_r($permission);echo '</pre>';
    foreach($permission as $key=>$val){
        
        
        $sub_menu_sql = mysqli_query($con,"select * from sub_menu where id='".$val."' and inventory=1");
        if(mysqli_num_rows($sub_menu_sql)>0){
          $sub_menu_sql_result = mysqli_fetch_assoc($sub_menu_sql);
        
          $mainmenu[] = $sub_menu_sql_result['main_menu'];
        }
        
    }
   // echo '<pre>';print_r($mainmenu);echo '</pre>';
$mainmenu    = array_unique($mainmenu);
//echo '<pre>';print_r($mainmenu);echo '</pre>';die;
?>
    


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">



<nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Navigation</div>
                        
                            <ul class="pcoded-item pcoded-left-item">
                                
                        <li <?php if(basename($_SERVER['REQUEST_URI'])=='index.php'){ echo "class='active'"; }?>>
                                    <a href="index.php">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                        
                                
                        
                        <?
                        
                        foreach($mainmenu as $menu=>$menu_id){
                        
                        $menu_sql = mysqli_query($con,"select * from main_menu where id='".$menu_id."' and inventory=1");
                        $menu_sql_result = mysqli_fetch_assoc($menu_sql);
                        $main_name = $menu_sql_result['name']; 
                        $icon = $menu_sql_result['icon'];
                        ?>

                            <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon">
                                            
                                            <?
                                            if($main_name=='Admin'){
                                                echo '<i class="fa fa-american-sign-language-interpreting"></i>';                                                
                                            }else if($main_name=='sites'){
                                                echo '<i class="fa fa-sitemap"></i></span>';   
                                            } else if($main_name=='mis'){
                                                echo '<i class="feather icon-gitlab"></i>';
                                            }else if($main_name=='Accounts'){
                                                echo '<i class="feather icon-pie-chart"></i>';
                                            }else if($main_name=='Report'){
                                                echo '<i class="feather icon-box"></i>';
                                            }else if($main_name=='Footage Request'){
                                                echo '<i class="feather icon-image"></i>';
                                            }else if($main_name=='Project'){
                                                echo '<i class="feather icon-aperture rotate-refresh"></i>';
                                            }else if($main_name=='Feasibility'){
                                                echo '<i class="feather icon-gitlab"></i>';
                                            }else if($main_name=='Leads'){
                                                echo '<i class="fa fa-list-alt"></i>';
                                            }else if($main_name=='Inventory'){
                                                echo '<i class="feather icon-pie-chart"></i>';
                                            }
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            ?>
                                            </span>
                                            <span class="pcoded-mtext"><? echo $main_name; ?></span>
                                    </a>
                                    
                                    
                                    <ul class="pcoded-submenu">                                    
                                        <?
                                        
                                        $submenu_sql = mysqli_query($con,"select * from sub_menu where main_menu = '".$menu_id."' and id in ($cpermission) and inventory=1");
                                        while($submenu_sql_result = mysqli_fetch_assoc($submenu_sql)){ 
                                        $page = $submenu_sql_result['page'];
                                        $submenu_name = $submenu_sql_result['sub_menu'];
                                        
                                        if(basename($_SERVER['REQUEST_URI'])==$page){
                                            $className = 'active' ; 
                                        }else{
                                            $className = '' ; 
                                        }
                                        
                                        ?>
                                            
                                            <li class="<? echo $className; ?>">
                                                <a href="<? echo $page; ?>">
                                                    <span class="pcoded-mtext"><? echo $submenu_name; ?></span>
                                                </a>
                                            </li>
                                        
                                        <? } ?>
                                        
                                    </ul>
                                </li>
                                
                                
                        <? }
                        
                        ?>
                        <li class="">
                                    <a href="logout.php">
                                        <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                                        <span class="pcoded-mtext">Logout</span>
                                    </a>
                                </li>
                                
                            
                            </ul>
                        </div>
                    </nav>
                    <? } ?>
                    
                    
<script>
$(document).ready(function() {
    $('.pcoded-submenu li.active').parents('li.pcoded-hasmenu').addClass('pcoded-trigger');
});
window.addEventListener('load', () => {
  // Delay the override to ensure the CDN file has loaded
  setTimeout(() => {
    const divElement = document.querySelector('#pcoded'); // Select the <div> element
    divElement.setAttribute('nav-type', 'st5'); // Override the nav-type attribute value to "st6"
  }, 1000); // Adjust the delay (in milliseconds) based on the CDN file's loading time
});

                    </script>