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
                                        $name = $_POST['name'];
                                        $uname = $_POST['uname'];
                                        $pwd = $_POST['pwd'];
                                        $contact = $_POST['contact'];
                                        $role = $_POST['role'];
                                        
                                        $sql= "insert into inventoryUsers(name,uname,pwd,contact,level,user_status,created_at,created_by) values('".$name."','".$uname."','".$pwd."','".$contact."','".$role."',1,'".$datetime."','".$userid."')";
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('User Created Successfully');
                                                 window.location.href="inventoryUsers.php";
                                             </script>
                                         <? }else{ ?>
                                             <script>
                                                 alert('User Created Error');
                                                 window.location.href="inventoryUsers.php";
                                             </script>
                                         <? } ?>
                                        

                                        
                                        
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


</body>

</html>