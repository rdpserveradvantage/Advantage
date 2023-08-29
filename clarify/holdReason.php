<?php include('header.php'); ?>
  
<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">
        <div class="page-body">
          <div class="card">
            <div class="card-block">
              <h1>Customer Dependency</h1>

              <form>
                <label for="dependency">Select the customer dependency:</label>
                <select id="dependency" name="dependency">
                  <option value="ATM Shutter Down">ATM Shutter Down</option>
                  <option value="Permission Issue">Permission Issue</option>
                  <option value="Back Room Key">Back Room Key</option>
                  <option value="Back Room EM lock">Back Room EM lock</option>
                  <option value="ATM Machine Down">ATM Machine Down</option>
                  <option value="Power issue">Power issue</option>
                  <option value="Electrical issue">Electrical issue</option>
                  <option value="UPS Issue">UPS Issue</option>
                  <option value="Rodent issue">Rodent issue</option>
                  <option value="LL rent issue">LL rent issue</option>
                  <option value="ATM Renovation">ATM Renovation</option>
                  <option value="ATM Relocation">ATM Relocation</option>
                  <option value="Unwanted Material kept in backroom">Unwanted Material kept in backroom</option>
                  <option value="ATM Lan cable Faulty">ATM Lan cable Faulty</option>
                  <option value="Late night access not available">Late night access not available</option>
                  <option value="Ladder Required">Ladder Required</option>
                  <option value="ATM Not Available">ATM Not Available</option>
                </select>
              </form>

              <div id="powerIssueDropdown" style="display: none;">
                <label for="powerIssue">Select the specific power issue:</label>
                <select id="powerIssue" name="powerIssue">
                  <option value="Area Power failure">Area Power failure</option>
                  <option value="ATM Power Disconnect by EB Department Due bill not paid">ATM Power Disconnect by EB Department Due bill not paid</option>
                  <option value="Main Power Cable burn">Main Power Cable burn</option>
                  <option value="Meter faulty">Meter faulty</option>
                </select>
              </div>

              <div id="electricalIssueDropdown" style="display: none;">
                <label for="electricalIssue">Select the specific electrical issue:</label>
                <select id="electricalIssue" name="electricalIssue">
                  <option value="No power availble in router socket">No power availble in router socket</option>
                  <option value="DB Box Short Circuit">DB Box Short Circuit</option>
                  <option value="MCB Faulty">MCB Faulty</option>
                  <option value="Earthing issue">Earthing issue</option>
                </select>
              </div>

              <div id="upsIssueDropdown" style="display: none;">
                <label for="upsIssue">Select the specific UPS issue:</label>
                <select id="upsIssue" name="upsIssue">
                  <option value="UPS Not availble">UPS Not availble</option>
                  <option value="UPS Faulty">UPS Faulty</option>
                  <option value="UPS Battery backup issue">UPS Battery backup issue</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>

<script>
  var dependencyDropdown = document.getElementById("dependency");
  var powerIssueDropdown = document.getElementById("powerIssueDropdown");
  var electricalIssueDropdown = document.getElementById("electricalIssueDropdown");
  var upsIssueDropdown = document.getElementById("upsIssueDropdown");

  dependencyDropdown.addEventListener("change", function() {
    var selectedOption = dependencyDropdown.options[dependencyDropdown.selectedIndex].value;

    if (selectedOption === "Power issue") {
      powerIssueDropdown.style.display = "block";
      electricalIssueDropdown.style.display = "none";
      upsIssueDropdown.style.display = "none";
    } else if (selectedOption === "Electrical issue") {
      powerIssueDropdown.style.display = "none";
      electricalIssueDropdown.style.display = "block";
      upsIssueDropdown.style.display = "none";
    } else if (selectedOption === "UPS Issue") {
      powerIssueDropdown.style.display = "none";
      electricalIssueDropdown.style.display = "none";
      upsIssueDropdown.style.display = "block";
    } else {
      powerIssueDropdown.style.display = "none";
      electricalIssueDropdown.style.display = "none";
      upsIssueDropdown.style.display = "none";
    }
  });
</script>
