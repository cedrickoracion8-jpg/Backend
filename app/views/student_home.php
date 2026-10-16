<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nature | Home</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #2e7d32, #a5d6a7);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Nature background circles */
        body::before {
            content: "";
            position: absolute;
            width: 700px;
            height: 700px;
            border: 3px solid rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            box-shadow:
                0 0 0 70px rgba(255,255,255,0.08),
                0 0 0 140px rgba(255,255,255,0.06),
                0 0 0 210px rgba(255,255,255,0.04),
                0 0 0 280px rgba(255,255,255,0.03);
        }

        .container {
            width: 600px;
            text-align: center;
            background: rgba(20, 60, 25, 0.90);
            padding: 45px;
            border-radius: 25px;
            border: 4px solid #81c784;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
        }

        .nature {
            font-size: 70px;
            margin-bottom: 10px;
        }

        h1 {
            color: #c8e6c9;
            font-size: 38px;
            text-transform: uppercase;
            text-shadow: 2px 2px 0 #1b5e20;
            margin-bottom: 15px;
        }

        .welcome {
            font-size: 20px;
            margin-bottom: 30px;
            color: #e8f5e9;
        }

        .nav {
            margin-bottom: 25px;
        }

        .nav a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background: #388e3c;
            padding: 12px 25px;
            margin: 5px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
            border: 2px solid #81c784;
        }

        .nav a:hover {
            background: #1b5e20;
            transform: scale(1.08);
        }

        .quote {
            color: #c8e6c9;
            font-style: italic;
            margin-top: 25px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="nature">🌿🌳</div>

        <h1>Student Home Page</h1>

        <p class="welcome">
            Welcome to the Student Home Page!
        </p>

        <div class="nav">
            <a href="/student">Home</a>
            <a href="/student/profile">Profile</a>
        </div>


        <p class="quote">
            🌱 "Take only memories, leave only footprints." 🌱
        </p>

    </div>

</body>
</html>
