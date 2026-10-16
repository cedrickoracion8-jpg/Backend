<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nature | Student Profile</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2e7d32, #a5d6a7);
            min-height: 100vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            width: 700px;
            height: 700px;
            border: 3px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            box-shadow:
                0 0 0 70px rgba(255,255,255,0.08),
                0 0 0 140px rgba(255,255,255,0.06),
                0 0 0 210px rgba(255,255,255,0.05),
                0 0 0 280px rgba(255,255,255,0.04);
        }

        .container {
            width: 500px;
            background: rgba(20, 60, 25, 0.90);
            padding: 30px;
            border-radius: 20px;
            border: 4px solid #81c784;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.6);
            position: relative;
            z-index: 1;
        }

        .nature {
            text-align: center;
            font-size: 55px;
        }

        h1 {
            text-align: center;
            color: #c8e6c9;
            font-size: 32px;
            text-transform: uppercase;
            text-shadow: 2px 2px 0 #1b5e20;
            margin-top: 5px;
        }

        .nav {
            text-align: center;
            margin-bottom: 25px;
        }

        .nav a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background: #388e3c;
            padding: 10px 18px;
            margin: 5px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .nav a:hover {
            background: #1b5e20;
            transform: scale(1.05);
        }

        .info {
            background: #f5f5f5;
            color: #111;
            padding: 20px;
            border-radius: 12px;
            border-left: 8px solid #388e3c;
        }

        .info p {
            margin: 8px 0;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .label {
            font-weight: bold;
            color: #2e7d32;
        }

        .hobbies {
            margin-top: 10px;
            padding: 10px;
        }

        .hobbies span {
            display: inline-block;
            background: #388e3c;
            color: white;
            padding: 7px 12px;
            margin: 4px;
            border-radius: 20px;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #c8e6c9;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="nature">🌿🌳</div>

        <h1>Student Profile</h1>

        <div class="nav">
            <a href="<?=site_url('student');?>">Home</a>
            <a href="<?=site_url('student/profile');?>">Profile</a>
        </div>

        <div class="info">

            <p>
                <span class="label">Student ID:</span>
                <?php echo $student_id; ?>
            </p>

            <p>
                <span class="label">Name:</span>
                Oracion, John Cedrick M.
            </p>

            <p>
                <span class="label">Course:</span>
                BS Information Technology
            </p>

            <p>
                <span class="label">Year:</span>
                3rd Year
            </p>

            <p>
                <span class="label">Section:</span>
                3F3
            </p>

            <p>
                <span class="label">Email:</span>
                johnoracion@example.com
            </p>

            <p>
                <span class="label">Phone:</span>
                09171234567
            </p>

            <p>
                <span class="label">Address:</span>
                Pinamalayan, Or. Min
            </p>

            <div class="hobbies">
                <span class="label">Hobbies:</span>

                <span>Hiking</span>
                <span>Photography</span>
                <span>Playing Basketball</span>
            </div>

        </div>

        <div class="footer">
            🌱 "Protect nature, preserve the future." 🌱
        </div>

    </div>

</body>
</html>

