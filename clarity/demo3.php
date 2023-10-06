<!DOCTYPE html>
<html>
<head>
  <title>Open All Select Tags on Load</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <form id="sitesForm" action="sitestest.php" method="POST">
      <div class="row">    
                                                <div class="col-md-3">
                                                    <label>ATMID</label>
                                                    <input type="text" class="form-control" name="atmid" value="">    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>Feasibilty Done</label>
                                                    <select name="isFeasibiltyDone" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    
                                                </div>
                                                
                                                
                                                <div class="col-md-2">
                                                    <label>Customer</label>
                                                    <select name="cust" class="form-control mdb-select md-form" searchable="Search here..">

                                                        <option value="">-- Select Customer --</option>
                                                        
                                                        											        <option value="SBI">
											         SBI											         </option>
											                                                             </select>
                                                    
                                                </div>
                                                
                                                
                                                <div class="col-md-2">
                                                    <label>State</label>
                                                    <select name="state" class="form-control">
                                                        <option value="">-- Select State--</option>
                                                        
                                                        											        <option value="Bihar">
											         Bihar											         </option>
											         											        <option value="Goa">
											         Goa											         </option>
											         											        <option value="Maharashatra">
											         Maharashatra											         </option>
											         											        <option value="Maharashtra">
											         Maharashtra											         </option>
											                                                             </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <label>Delegated</label>
                                                    <select name="isDelegated" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    
                                                </div>
                                                

                                            </div>
                                            <br>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
    <script>
      $(document).ready(function() {
        // Trigger the click event for all select elements
        $("select").each(function() {
          $(this).prev("div").find(".select-wrapper").click();
        });
      });
    </script>
  </form>
</body>
</html>
