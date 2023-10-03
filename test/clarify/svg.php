<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Software Installation Icon</title>
    <style>
        .person {
            animation: movePerson 4s linear infinite;
        }

        @keyframes movePerson {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(30px);
            }
            100% {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
        <!-- Draw the person -->
        <circle class="person" cx="100" cy="60" r="40" fill="#0073e6" />
        <line x1="100" y1="100" x2="100" y2="180" stroke="#0073e6" stroke-width="6" />

        <!-- Draw the computer -->
        <rect x="80" y="120" width="40" height="30" fill="#333" />
        <rect x="85" y="90" width="30" height="30" fill="#333" />
        <ellipse cx="100" cy="150" rx="12" ry="8" fill="#333" />

        <!-- Draw the arrow -->
        <polygon points="100,180 90,170 110,170" fill="#0073e6" />
    </svg>
</body>
</html>
