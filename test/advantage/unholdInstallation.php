<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <?
                                        $siteid = $_REQUEST['siteid'];
                                        $atmid = $_REQUEST['atmid'];
                                        
                                        $sql = "update sites set isDelegated=0,isFeasibiltyDone=0,ESD='0000-00-00 00:00:00',ASD='0000-00-00 00:00:00',
                                        delegatedByVendor=0,verificationStatus='' where id='".$siteid."' and atmid='".$atmid."'";
                                        
                                        if(mysqli_query($con,$sql)){
                                        unholdInstallation($siteid,$atmid,'');
                                            mysqli_query($con,"update holdInstallation set status=0 where siteid='".$siteid."' and atmid='".$atmid."'");
                                        }

                                        ?>
                                        <br />
                                        <br />
                                        <script>
                                            alert('UnHold Done Successfully !');
                                        window.history.back();    
                                        </script>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>