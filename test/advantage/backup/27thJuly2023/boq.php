<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        


        <h5>BOQ Management</h5>
        <hr />
        <table class="table">
            <thead>
                <tr>
                    <!--<th>Attribute</th>-->
                    <th>BOQ</th>
                    <th>Count</th>
                    <!--<th>Status</th>-->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="boq-data"></tbody>
        </table>


    <!-- Modal for updating BOQ record -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update BOQ Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="recordId">
                    <!--<div class="form-group">-->
                    <!--    <label for="attribute">Attribute</label>-->
                    <!--    <input type="text" class="form-control" id="attribute">-->
                    <!--</div>-->
                    <div class="form-group">
                        <label for="value">Value</label>
                        <input type="text" class="form-control" id="value">
                    </div>
                    <div class="form-group">
                        <label for="count">Count</label>
                        <input type="text" class="form-control" id="count">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateRecord()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load BOQ data on page load
            loadBOQData();
        });

        // Function to load BOQ data
        function loadBOQData() {
            $.ajax({
                url: 'get_boq.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var boqData = '';
                    $.each(data, function(key, value) {
                        boqData += '<tr>';
                        // boqData += '<td>' + value.attribute + '</td>';
                        boqData += '<td>' + value.value + '</td>';
                        boqData += '<td>' + value.count + '</td>';
                        // boqData += '<td>' + value.status + '</td>';
                        boqData += '<td>';
                        boqData += '<button type="button" class="btn btn-primary" onclick="openUpdateModal(' + value.id + ')">Edit</button>';
                        boqData += '</td>';
                        boqData += '</tr>';
                    });
                    $('#boq-data').html(boqData);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        // Function to open the update modal and pre-fill the record data
        function openUpdateModal(id) {
            $.ajax({
                url: 'get_single_boq.php?id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#recordId').val(data.id);
                    // $('#attribute').val(data.attribute);
                    $('#value').val(data.value);
                    $('#count').val(data.count);
                    $('#status').val(data.status);
                    $('#updateModal').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        // Function to update the BOQ record
        function updateRecord() {
            var id = $('#recordId').val();
            var count = $('#count').val();
            var status = $('#status').val();
            var value = $('#value').val();

            $.ajax({
                url: 'update_boq.php',
                type: 'POST',
                data: {
                    id: id,
                    count: count,
                    status: status,
                    value:value
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    // Close the modal and refresh the BOQ data
                    $('#updateModal').modal('hide');
                    loadBOQData();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    </script>



                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>