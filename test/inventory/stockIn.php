<?php include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
                            <div class="two_end">
                                <h5>Stock In <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                <a class="btn btn-success" href="excelformat/inventoryBulkUploadFormat.xlsx"
                                    download>Stock In Bulk Format </a>
                            </div>

                            <hr>
                            <form id="uploadForm" action="save_product.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls">
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="inventoryType" id="inventoryType" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="Internal">Internal</option>
                                            <option value="Actual">Actual</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <input type="submit" value="Upload" class="btn btn-primary" name="submit">
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
    document.getElementById('uploadForm').addEventListener('submit', function (e) {
        var excelFile = document.getElementById('excelFile').value;
        if (excelFile === '') {
            e.preventDefault();
            alert('Please select a file.');
        }
    });
</script>

<?php include('footer.php'); ?>