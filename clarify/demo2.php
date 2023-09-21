
<? return ;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Style the divider option to add a visible line */
        option.divider {
            border-top: 1px solid black;
            font-weight: bold;
            background-color: lightgray;
        }
    </style>
</head>
<body>
<select>

    <option class="divider" disabled>---------------------------ADV---------------------------------------------</option> <!-- Divider option -->
        <option value="spares-replaced">Spares Replaced</option>
        <option value="antenna-relocated">Antenna Relocated</option>
        <option value="antenna-replaced">Antenna Replaced</option>
        <option value="router-rebooted">Router Rebooted</option>
        <option value="lab-cable-replaced">Lab Cable Replaced or Label Fixed (if damaged)</option>
        <option value="electrical-wiring-for-router">Electrical Wiring for Router Done</option>
        <option value="sim-replaced">SIM Replaced</option>
        <option value="sim-reinserted">SIM Re-Inserted</option>
        <option value="no-issue-found">No Issue Found</option>

    <option class="divider" disabled>---------------------------BANK---------------------------------------------</option> <!-- Divider option -->
    <option value="atm-shutter-down">ATM Shutter Down</option>
        <option value="permission-issue">Permission Issue</option>
        <option value="back-room-key">Back Room Key</option>
        <option value="back-room-em-lock">Back Room EM Lock</option>
        <option value="atm-machine-down">ATM Machine Down</option>

        <optgroup label="Power Issue">
            <option value="area-power-failure">Area Power Failure</option>
            <option value="atm-power-disconnect">ATM Power Disconnect by EB Department Due Bill Not Paid</option>
            <option value="main-power-cable-burn">Main Power Cable Burn</option>
            <option value="meter-faulty">Meter Faulty</option>
        </optgroup>
        <optgroup label="Electrical issue">
            <option value="No-Power-Available-in-Router-Socket">a) No power available in router socket</option>
            <option value="DB-Box-Short-Circuit">b) DB Box Short Circuit</option>
            <option value="MCB-Faulty">c) MCB Faulty.</option>
            <option value="Earthing-Issue">d) Earthing issue</option>
        </optgroup>
        <optgroup label="UPS Issue">
            <option value="UPS-Not-Available">UPS Not available</option>
            <option value="UPS-Faulty">UPS Faulty</option>
            <option value="UPS-Battery-Backup-Issue">UPS Battery backup issue</option>
        </optgroup>
        <option value="Rodent-Issue">Rodent issue</option>
        <option value="LL-Rent-Issue">LL rent issue</option>
        <option value="ATM-Renovation">ATM Renovation</option>

</select>
</body>
</html>
