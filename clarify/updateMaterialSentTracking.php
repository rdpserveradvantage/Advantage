<? include('header.php'); 

$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
$id = $_REQUEST['id'];



?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        <h5 style="font-weight: 600;">Update Tracking Status: <span style="color:red; "><? echo $atmid; ?> </span></h5>
                                        <hr>

                                        <form id="updateMaterialSentTracking" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<? echo $id ; ?>" />
                                            <input type="hidden" name="atmid" value="<? echo $atmid ; ?>" />
                                            <input type="hidden" name="siteid" value="<? echo $siteid ; ?>" />
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>POD</label>
                                                    <input type="text" name="pod" class="form-control" required />
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Receivers Name</label>
                                                    <input type="text" name="receiversName" class="form-control" value="<?= $_SESSION['SERVICE_username']; ?>" required readonly  />
                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <label>Receivers Number</label>
                                                    <input type="text" name="receiversNumber" class="form-control" value="<?= $_SESSION['SERVICE_userNumber']; ?>" required />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Received Date</label>
                                                    <input type="date" name="receivedDate" value="<?= date('Y-m-d'); ?>" class="form-control" required />
                                                </div>
                                                
                                                <div class="col-sm-6">
                                                    <label>Received Time</label>
                                                    <input type="time" name="receivedTime" class="form-control" value="<?php echo date('H:i'); ?>" required />

                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <br/>
                                                    <button id="submitFormButton" type="button" class="btn btn-primary">Submit</button>    
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
                    


<script>
function saveFormData() {
    var form = document.getElementById('updateMaterialSentTracking');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'process_updateMaterialSentTracking.php');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === '200') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        window.location.href = "materialSent.php";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error saving form data. Please try again.'
                });
            }
        }
    };
    xhr.send(formData);
}



    // Attach event listener to the submit button
    var submitButton = document.getElementById('submitFormButton');
    submitButton.addEventListener('click', saveFormData);
</script>

    <? include('footer.php'); ?>