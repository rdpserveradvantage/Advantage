<? include('header.php'); ?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <?
                                        $RailTailVendorID ; 
                                        $name = $_POST['name'];
                                        $uname = $_POST['uname'];
                                        $pwd = $_POST['pwd'];
                                        $contact = $_POST['contact'];
                                        $role = $_POST['role'];
                                        $address = $_REQUEST['address'];
                                        if($role==1){
                                            $permission = '15,76,78';
                                        }else if($role==2){
                                            
                                        }else if($role==3){
                                            $permission = '76';
                                        }
                                        
                                        
                                        $sql= "insert into vendorUsers(vendorId,name,uname,password,contact,level,user_status,permission,address) values('".$RailTailVendorID."','".$name."','".$uname."','".$pwd."','".$contact."','".$role."',1,'".$permission."','".$address."')";
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('User Created Successfully');
                                                 window.location.href="add_user.php";
                                             </script>
                                         <? }else{ ?>
                                             <script>
                                                 alert('User Created Error');
                                                 window.location.href="add_user.php";
                                             </script>
                                         <? } ?>
                                        

                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>