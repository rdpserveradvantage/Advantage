<? include('header.php'); ?>
<link rel="stylesheet" type="text/css" href="datatable/dataTables.bootstrap.css">
     
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
                                        
                                        if($role==5){
                                            $sql= "insert into vendorUsers(name,uname,password,contact,level,user_status) values('".$name."','".$uname."','".$pwd."','".$contact."','".$role."',1)";
                                        }else{
                                            $sql= "insert into mis_loginusers(name,uname,pwd,contact,level,user_status) values('".$name."','".$uname."','".$pwd."','".$contact."','".$role."',1)";                                            
                                        }
                                        
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
