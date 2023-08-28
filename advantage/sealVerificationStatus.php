<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                        <?
                                        $id = $_REQUEST['id'];
                                        $isVerfy= $_REQUEST['isVerfy'];
                                        $siteid=$_REQUEST['siteid'];
                                        $atmid = $_REQUEST['atmid'];
                                        
                                        $sql = "update sealVerification set isVerify= '".$isVerfy."' ,updated_at='".$datetime."' where id='".$id."'";
                                        if(mysqli_query($con,$sql)){
                                            
                                            if($isVerfy==1){ ?>
                                                <div class="alert alert-success background-success">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="icofont icofont-close-line-circled text-white"></i>
                                                </button>
                                                <strong>Success!</strong> 
                                                <code> Verification Successful ! </code>
                                                </div>
                                            <? }else{
                                                ?>
                                                <div class="alert alert-danger background-danger">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="icofont icofont-close-line-circled text-white"></i>
                                                </button>
                                                <strong>Success !</strong> 
                                                <code> Verification Rejected ! </code>
                                                </div>
                                            <? }
                                            
                                        }
                                        
                                        ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>