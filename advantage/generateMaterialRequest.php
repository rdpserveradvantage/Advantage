<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        <form action="process_generateMaterialRequest.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Enter Space Seprated ATMID <span style="color:red;">( if multiple )</span></label>
                                                    <input type="text" name="atmid" class="form-control" required />                                                    
                                                </div>
                                            </div>

                                            <br />
                                            <input type="submit" name="submit" class="btn btn-primary" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>