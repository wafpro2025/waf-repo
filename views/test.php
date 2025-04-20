<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sorry, you have been blocked</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f9f9f9;
        }

        .error-icon {
            font-size: 100px;
            color: red;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        h1 {
            color: #333;
        }

        .section {
            margin-top: 30px;
            text-align: left;
        }

        .section h3 {
            margin-bottom: 10px;
            color: #444;
        }

        .section p {
            color: #555;
        }

        .footer {
            margin-top: 50px;
            font-size: 14px;
            color: #555;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="error-icon">❌</div>
        <h1>Sorry, you have been blocked</h1>
        <p>You are unable to access this website.</p>

        <div class="section">
            <h3>Why have I been blocked?</h3>
            <p>This website is using a security service to protect itself from online attacks. The action you just performed triggered the security solution. There are several actions that could trigger this block including submitting a certain word or phrase, a SQL command or malformed data.</p>
        </div>

        <div class="section">
            <h3>What can I do to resolve this?</h3>
            <p>You can email the site owner to let them know you were blocked. Please include what you were doing when this page came up and the Cloudflare Ray ID found at the bottom of this page.</p>
        </div>

        <div class="footer">
            Cloudflare Ray ID: <strong>7e9757f8235b5453</strong> •
            Your IP: <strong><?php echo $_SERVER['REMOTE_ADDR']; ?></strong> •
            Performance & security by <a href="https://www.cloudflare.com/" target="_blank">Cloudflare</a>
        </div>
    </div>

</body>

</html>