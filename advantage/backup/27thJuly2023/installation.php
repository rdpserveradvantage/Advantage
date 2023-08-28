<? include('header.php'); ?>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #000;
        }
        #signatureCanvas {
            border: 1px solid #000;
        }
    </style>
    
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <a href="holdReason.php" target="_blank">Hold Reason</a>
                                <form id="installationForm" enctype="multipart/form-data">
  <table>
    <tr>
      <td colspan="2"><h2>Installation</h2></td>
    </tr>
    <tr>
      <td><h3>Sr. Particular</h3></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="atmId">ATM ID:</label></td>
      <td><input type="text" id="atmId" name="atmId"></td>
    </tr>
    <tr>
      <td><label for="atmId2">ATM ID 2:</label></td>
      <td><input type="text" id="atmId2" name="atmId2"></td>
    </tr>
    <tr>
      <td><label for="atmId3">ATM ID 3:</label></td>
      <td><input type="text" id="atmId3" name="atmId3"></td>
    </tr>
    <tr>
      <td><label for="address">Address:</label></td>
      <td><input type="text" id="address" name="address"></td>
    </tr>
    <tr>
      <td><label for="city">City:</label></td>
      <td><input type="text" id="city" name="city"></td>
    </tr>
    <tr>
      <td><label for="location">Location:</label></td>
      <td><input type="text" id="location" name="location"></td>
    </tr>
    <tr>
      <td><label for="lho">LHO:</label></td>
      <td><input type="text" id="lho" name="lho"></td>
    </tr>
    <tr>
      <td><label for="state">State:</label></td>
      <td><input type="text" id="state" name="state"></td>
    </tr>
    <tr>
      <td><label for="atmWorking1">Atm 1 Working </label></td>
      <td>
          <select name="atmWorking1" required>
              <option value="">Select</option>
              <option>Yes</option>
              <option>No</option>
          </select>
    </td>
    </tr>
    <tr>
      <td><label for="atmWorking2">Atm 2 Working </label></td>
      <td>
          <select name="atmWorking2" required>
              <option value="">Select</option>
              <option>Yes</option>
              <option>No</option>
          </select>
    </td>
    </tr>
    <tr>
      <td><label for="atmWorking3">Atm 3 Working </label></td>
      <td>
          <select name="atmWorking3" required>
              <option value="">Select</option>
              <option>Yes</option>
              <option>No</option>
          </select>
    </td>
    </tr>
    <tr>
      <td><label for="vendorName">Installation Vendor Name:</label></td>
      <td><input type="text" id="vendorName" name="vendorName"></td>
    </tr>
    <tr>
      <td><label for="engineerName">Installation Engineer Name & Number:</label></td>
      <td><input type="text" id="engineerName" name="engineerName"><input type="text" id="engineerNumber" name="engineerNumber"></td>

    </tr>
    <tr>
      <td><h3>Router</h3></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="routerSerial">Serial No:</label></td>
      <td><input type="text" id="routerSerial" name="routerSerial"></td>
    </tr>
    <tr>
      <td><label for="routerMake">Make:</label></td>
      <td><input type="text" id="routerMake" name="routerMake"></td>
    </tr>
    <tr>
      <td><label for="routerModel">Model:</label></td>
      <td><input type="text" id="routerModel" name="routerModel"></td>
    </tr>
    <tr>
      <td><h3>Router_Fixed</h3></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="routerFixedYes">Yes:</label></td>
      <td><input type="radio" id="routerFixedYes" name="routerFixed" value="yes"></td>
    </tr>
    <tr>
      <td><label for="routerFixedNo">No:</label></td>
      <td><input type="radio" id="routerFixedNo" name="routerFixed" value="no"></td>
    </tr>
    <tr>
      <td><label for="routerFixedRemarks">Remarks:</label></td>
      <td><input type="text" id="routerFixedRemarks" name="routerFixedRemarks"></td>
    </tr>
    <tr>
      <td><label for="routerFixedSnaps">Snaps:</label></td>
      <td><input type="file" id="routerFixedSnaps" name="routerFixedSnaps"></td>
    </tr>
    <tr>
      <td><h3>Router Status</h3></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="routerStatusWorking">Working:</label></td>
      <td><input type="radio" id="routerStatusWorking" name="routerStatus" value="working"></td>
    </tr>
    <tr>
      <td><label for="routerStatusNotWorking">Not Working:</label></td>
      <td><input type="radio" id="routerStatusNotWorking" name="routerStatus" value="notWorking"></td>
    </tr>
    <tr>
      <td><label for="routerStatusRemarks">Remarks:</label></td>
      <td><input type="text" id="routerStatusRemarks" name="routerStatusRemarks"></td>
    </tr>
    <tr>
      <td><label for="routerStatusSnaps">Snaps:</label></td>
      <td><input type="file" id="routerStatusSnaps" name="routerStatusSnaps"></td>
    </tr>

 <tr>
      <td><h3>Adaport Installed</h3></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="adaportInstalledYes">Yes:</label></td>
      <td><input type="radio" id="adaportInstalledYes" name="adaportInstalled" value="yes"></td>
    </tr>
    <tr>
      <td><label for="adaportInstalledNo">No:</label></td>
      <td><input type="radio" id="adaportInstalledNo" name="adaportInstalled" value="no"></td>
    </tr>
    <tr>
      <td><label for="adaportSnaps">Snaps:</label></td>
      <td><input type="file" id="adaportSnaps" name="adaportSnaps"></td>
    </tr>
    <tr>
      <td><h3>Adaptor Status</h3></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="adaptorStatusWorking">Working:</label></td>
      <td><input type="radio" id="adaptorStatusWorking" name="adaptorStatus" value="working"></td>
    </tr>
    <tr>
      <td><label for="adaptorStatusNotWorking">Not Working:</label></td>
      <td><input type="radio" id="adaptorStatusNotWorking" name="adaptorStatus" value="notWorking"></td>
    </tr>
    <tr>
      <td><label for="adaptorStatusRemarks">Remarks:</label></td>
      <td><input type="text" id="adaptorStatusRemarks" name="adaptorStatusRemarks"></td>
    </tr>
    <tr>
      <td><label for="adaptorStatusSnaps">Snaps:</label></td>
      <td><input type="file" id="adaptorStatusSnaps" name="adaptorStatusSnaps"></td>
    </tr>
    
    
    
    
    
    
    
    
    
    <tr>
      <td><h3>LAN Cable Installed</h3></td>
      <td></td>
    </tr>
    <tr>
      <td><label for="lanCableInstalledYes">Yes:</label></td>
      <td><input type="radio" id="lanCableInstalledYes" name="lanCableInstalled" value="yes"></td>
    </tr>
    <tr>
      <td><label for="lanCableInstalledNo">No:</label></td>
      <td><input type="radio" id="lanCableInstalledNo" name="lanCableInstalled" value="no"></td>
    </tr>
    <tr>
      <td><label for="adaptorStatusRemarks">Remarks:</label></td>
      <td><input type="text" id="lanCableRemarks" name="lanCableRemarks"></td>
    </tr>
    <tr>
      <td><label for="adaptorStatusSnaps">Snaps:</label></td>
      <td><input type="file" id="lanCableSnaps" name="lanCableSnaps"></td>
    </tr>
    
    <!-- Continue adding the remaining fields -->
    <tr>
      <td colspan="2">
        <h3>LAN Cable Installed</h3>
        <label for="lanCableInstalledYes">Yes:</label>
        <input type="radio" id="lanCableInstalledYes" name="lanCableInstalled" value="yes">
        <label for="lanCableInstalledNo">No:</label>
        <input type="radio" id="lanCableInstalledNo" name="lanCableInstalled" value="no">
        <br>
        <label for="lanCableRemarks">Remarks:</label>
        <input type="text" id="lanCableRemarks" name="lanCableRemarks">
        <br>
        <label for="lanCableSnaps">Snaps:</label>
        <input type="file" id="lanCableSnaps" name="lanCableSnaps">
      </td>
    </tr>
    
    
    
    <tr>
      <td colspan="2">
        <h3>LAN Cable Status</h3>
        <label for="lanCableStatusWorking">Working:</label>
        <input type="radio" id="lanCableStatusWorking" name="lanCableStatus" value="working">
        <label for="lanCableStatusNotWorking">Not Working:</label>
        <input type="radio" id="lanCableStatusNotWorking" name="lanCableStatus" value="notWorking">
        <br>
        <label for="cableStatusRemarks">Remarks:</label>
        <input type="text" id="cableStatusRemarks" name="cableStatusRemarks">
        <br>
        <label for="cableStatusSnaps">Snaps:</label>
        <input type="file" id="cableStatusSnaps" name="cableStatusSnaps">
      </td>
    </tr>
    <!-- Continue adding the remaining fields -->
    <tr>
      <td colspan="2">
        <h3>4G Antenna Installed</h3>
        <label for="antennaInstalledYes">Yes:</label>
        <input type="radio" id="antennaInstalledYes" name="antennaInstalled" value="yes">
        <label for="antennaInstalledNo">No:</label>
        <input type="radio" id="antennaInstalledNo" name="antennaInstalled" value="no">
        <br>
        <label for="antennaRemarks">Remarks:</label>
        <input type="text" id="antennaRemarks" name="antennaRemarks">
        <br>
        <label for="antennaSnaps">Snaps:</label>
        <input type="file" id="antennaSnaps" name="antennaSnaps">
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h3>4G Antenna Status</h3>
        <label for="antennaStatusWorking">Working:</label>
        <input type="radio" id="antennaStatusWorking" name="antennaStatus" value="working">
        <label for="antennaStatusNotWorking">Not Working:</label>
        <input type="radio" id="antennaStatusNotWorking" name="antennaStatus" value="notWorking">
        <br>
        <label for="antennaStatusRemarks">Remarks:</label>
        <input type="text" id="antennaStatusRemarks" name="antennaStatusRemarks">
        <br>
        <label for="antennaStatusSnaps">Snaps:</label>
        <input type="file" id="antennaStatusSnaps" name="antennaStatusSnaps">
      </td>
    </tr>
    <!-- Continue adding the remaining fields -->
    <tr>
      <td colspan="2">
        <h3>GPS Antenna Installed</h3>
        <label for="gpsInstalledYes">Yes:</label>
        <input type="radio" id="gpsInstalledYes" name="gpsInstalled" value="yes">
        <label for="gpsInstalledNo">No:</label>
        <input type="radio" id="gpsInstalledNo" name="gpsInstalled" value="no">
        <br>
        <label for="gpsRemarks">Remarks:</label>
        <input type="text" id="gpsRemarks" name="gpsRemarks">
        <br>
        <label for="gpsSnaps">Snaps:</label>
        <input type="file" id="gpsSnaps" name="gpsSnaps">
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h3>GPS Antenna Status</h3>
        <label for="gpsStatusWorking">Working:</label>
        <input type="radio" id="gpsStatusWorking" name="gpsStatus" value="working">
        <label for="gpsStatusNotWorking">Not Working:</label>
        <input type="radio" id="gpsStatusNotWorking" name="gpsStatus" value="notWorking">
        <br>
        <label for="gpsStatusRemarks">Remarks:</label>
        <input type="text" id="gpsStatusRemarks" name="gpsStatusRemarks">
        <br>
        <label for="gpsStatusSnaps">Snaps:</label>
        <input type="file" id="gpsStatusSnaps" name="gpsStatusSnaps">
      </td>
    </tr>
    <!-- Continue adding the remaining fields -->
    <tr>
      <td colspan="2">
        <h3>Wifi Antenna Installed</h3>
        <label for="wifiInstalledYes">Yes:</label>
        <input type="radio" id="wifiInstalledYes" name="wifiInstalled" value="yes">
        <label for="wifiInstalledNo">No:</label>
        <input type="radio" id="wifiInstalledNo" name="wifiInstalled" value="no">
        <br>
        <label for="wifiRemarks">Remarks:</label>
        <input type="text" id="wifiRemarks" name="wifiRemarks">
        <br>
        <label for="wifiSnaps">Snaps:</label>
        <input type="file" id="wifiSnaps" name="wifiSnaps">
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h3>Wifi Antenna Status</h3>
        <label for="wifiStatusWorking">Working:</label>
        <input type="radio" id="wifiStatusWorking" name="wifiStatus" value="working">
        <label for="wifiStatusNotWorking">Not Working:</label>
        <input type="radio" id="wifiStatusNotWorking" name="wifiStatus" value="notWorking">
        <br>
        <label for="wifiStatusRemarks">Remarks:</label>
        <input type="text" id="wifiStatusRemarks" name="wifiStatusRemarks">
        <br>
        <label for="wifiStatusSnaps">Snaps:</label>
        <input type="file" id="wifiStatusSnaps" name="wifiStatusSnaps">
      </td>
    </tr>
    <!-- Continue adding the remaining fields -->
    <tr>
      <td colspan="2">
        <h3>Airte SIM Installed</h3>
        <label for="airteSimInstalledYes">Yes:</label>
        <input type="radio" id="airteSimInstalledYes" name="airteSimInstalled" value="yes">
        <label for="airteSimInstalledNo">No:</label>
        <input type="radio" id="airteSimInstalledNo" name="airteSimInstalled" value="no">
        <br>
        <label for="airteSimRemarks">Remarks:</label>
        <input type="text" id="airteSimRemarks" name="airteSimRemarks">
        <br>
        <label for="airteSimSnaps">Snaps:</label>
        <input type="file" id="airteSimSnaps" name="airteSimSnaps">
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h3>Airte SIM Status</h3>
        <label for="airteSimStatusWorking">Working:</label>
        <input type="radio" id="airteSimStatusWorking" name="airteSimStatus" value="working">
        <label for="airteSimStatusNotWorking">Not Working:</label>
        <input type="radio" id="airteSimStatusNotWorking" name="airteSimStatus" value="notWorking">
        <br>
        <label for="airteSimStatusRemarks">Remarks:</label>
        <input type="text" id="airteSimStatusRemarks" name="airteSimStatusRemarks">
        <br>
        <label for="airteSimStatusSnaps">Snaps:</label>
        <input type="file" id="airteSimStatusSnaps" name="airteSimStatusSnaps">
      </td>
    </tr>
    <!-- Continue adding the remaining fields -->
    <tr>
      <td colspan="2">
        <h3>Vodafone SIM Installed</h3>
        <label for="vodafoneSimInstalledYes">Yes:</label>
        <input type="radio" id="vodafoneSimInstalledYes" name="vodafoneSimInstalled" value="yes">
        <label for="vodafoneSimInstalledNo">No:</label>
        <input type="radio" id="vodafoneSimInstalledNo" name="vodafoneSimInstalled" value="no">
        <br>
        <label for="vodafoneSimRemarks">Remarks:</label>
        <input type="text" id="vodafoneSimRemarks" name="vodafoneSimRemarks">
        <br>
        <label for="vodafoneSimSnaps">Snaps:</label>
        <input type="file" id="vodafoneSimSnaps" name="vodafoneSimSnaps">
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h3>Vodafone SIM Status</h3>
        <label for="vodafoneSimStatusWorking">Working:</label>
        <input type="radio" id="vodafoneSimStatusWorking" name="vodafoneSimStatus" value="working">
        <label for="vodafoneSimStatusNotWorking">Not Working:</label>
        <input type="radio" id="vodafoneSimStatusNotWorking" name="vodafoneSimStatus" value="notWorking">
        <br>
        <label for="vodafoneSimStatusRemarks">Remarks:</label>
        <input type="text" id="vodafoneSimStatusRemarks" name="vodafoneSimStatusRemarks">
        <br>
        <label for="vodafoneSimStatusSnaps">Snaps:</label>
        <input type="file" id="vodafoneSimStatusSnaps" name="vodafoneSimStatusSnaps">
      </td>
    </tr>
    <!-- Continue adding the remaining fields -->
    <tr>
      <td colspan="2">
        <h3>JIO SIM Installed</h3>
        <label for="jioSimInstalledYes">Yes:</label>
        <input type="radio" id="jioSimInstalledYes" name="jioSimInstalled" value="yes">
        <label for="jioSimInstalledNo">No:</label>
        <input type="radio" id="jioSimInstalledNo" name="jioSimInstalled" value="no">
        <br>
        <label for="jioSimRemarks">Remarks:</label>
        <input type="text" id="jioSimRemarks" name="jioSimRemarks">
        <br>
        <label for="jioSimSnaps">Snaps:</label>
        <input type="file" id="jioSimSnaps" name="jioSimSnaps">
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h3>JIO SIM Status</h3>
        <label for="jioSimStatusWorking">Working:</label>
        <input type="radio" id="jioSimStatusWorking" name="jioSimStatus" value="working">
        <label for="jioSimStatusNotWorking">Not Working:</label>
        <input type="radio" id="jioSimStatusNotWorking" name="jioSimStatus" value="notWorking">
        <br>
        <label for="jioSimStatusRemarks">Remarks:</label>
        <input type="text" id="jioSimStatusRemarks" name="jioSimStatusRemarks">
        <br>
        <label for="jioSimStatusSnaps">Snaps:</label>
        <input type="file" id="jioSimStatusSnaps" name="jioSimStatusSnaps">
      </td>
    </tr>
    <tr>
      <td colspan="2">
          

    
        <h3>Signature of Engineer Installed</h3>
            
            <div>
                <label for="signatureCanvas">Digital Signature:</label>
                <canvas id="signatureCanvas" width="400" height="200"></canvas>
                <button type="button" onclick="clearSignature()">Clear</button>
            </div>
            
        <br>
        <label for="vendorStamp">Stamp of Vendor:</label>
        <input type="file" id="vendorStamp" name="vendorStamp">
      </td>
    </tr>
    <tr>
      <td colspan="2">
          <button type="button" onclick="submitForm()" id="submitButton">Submit</button>
          <div id="loadingIndicator" style="display: none;">Loading...</div>
      </td>
    </tr>
    
  </table>
</form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            



<script> var signatureCanvas;
  var signatureCtx;
  var isDrawing = false;
  var lastX = 0;
  var lastY = 0;

  // Function to initialize the signature canvas
  function initializeSignatureCanvas() {
    signatureCanvas = document.getElementById("signatureCanvas");
    signatureCtx = signatureCanvas.getContext("2d");

    signatureCanvas.addEventListener("mousedown", startDrawing);
    signatureCanvas.addEventListener("mousemove", draw);
    signatureCanvas.addEventListener("mouseup", stopDrawing);
    signatureCanvas.addEventListener("mouseout", stopDrawing);
  }

  // Function to start drawing
  function startDrawing(e) {
    isDrawing = true;
    lastX = e.offsetX;
    lastY = e.offsetY;
  }

  // Function to draw
  function draw(e) {
    if (!isDrawing) return;

    signatureCtx.beginPath();
    signatureCtx.moveTo(lastX, lastY);
    signatureCtx.lineTo(e.offsetX, e.offsetY);
    signatureCtx.stroke();

    lastX = e.offsetX;
    lastY = e.offsetY;
  }

  // Function to stop drawing
  function stopDrawing() {
    isDrawing = false;
  }

  // Function to clear the signature
  function clearSignature() {
    signatureCtx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
  }

  // Function to handle form submission
  function submitForm() {
    var form = document.getElementById("installationForm");
    var formData = new FormData(form);
    var serializedData = new URLSearchParams(formData).toString();
    var submitButton = document.getElementById("submitButton");
    var loadingIndicator = document.getElementById("loadingIndicator");
    
    // Convert the signature canvas to an image
    var signatureImage = signatureCanvas.toDataURL("image/png");

    // Append the signature image data to the form data
    formData.append("signatureImage", signatureImage);
    serializedData = new URLSearchParams(formData).toString();

    // Disable submit button and show loading indicator
    submitButton.disabled = true;
    loadingIndicator.style.display = "block";

    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_installation.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        // Enable submit button and hide loading indicator
        submitButton.disabled = false;
        loadingIndicator.style.display = "none";

        if (xhr.status === 200) {
          // Handle the successful response from the server
          console.log(xhr.responseText);
        } else {
          // Handle errors or non-200 status codes
          console.error("An error occurred.");
        }
      }
    };
    xhr.send(serializedData);
  }

  // Initialize the signature canvas when the page is loaded
  window.addEventListener("load", initializeSignatureCanvas);
</script>

<? include('footer.php'); ?>
