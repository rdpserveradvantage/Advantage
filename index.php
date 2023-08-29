<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Landing Page</title>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #particles-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .portal-cards {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            z-index: 1;
        }
        .portal-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            text-align: center;
            width: 260px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 2;
        }
        .portal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
        .portal-title {
            font-size: 22px;
            margin-bottom: 10px;
            color: #333;
        }
        .portal-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.2s;
        }
        .portal-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="particles-bg"></div>
    <div class="portal-cards">
        <div class="portal-card">
            <div class="portal-title">Vendor Portal</div>
            <a class="portal-link" href="RailTelVendor">Go to Portal</a>
        </div>
        <div class="portal-card">
            <div class="portal-title">Advantage Portal</div>
            <a class="portal-link" href="advantage">Go to Portal</a>
        </div>
        <div class="portal-card">
            <div class="portal-title">Inventory Portal</div>
            <a class="portal-link" href="advantageInventory">Go to Portal</a>
        </div>
        <div class="portal-card">
            <div class="portal-title">Clarify Portal</div>
            <a class="portal-link" href="clarify">Go to Portal</a>
        </div>
        <div class="portal-card">
            <div class="portal-title">Clarity Portal</div>
            <a class="portal-link" href="clarity">Go to Portal</a>
        </div>
    </div>
    <script>
        particlesJS.load('particles-bg', 'particles.json', function() {
            console.log('Particles.js loaded');
        });
    </script>
</body>
</html>


