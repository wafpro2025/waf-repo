<?php
session_start();
include("../php/config.php");

// Check if the user is a SOC Analyst
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'soc_analyst') {
    header("Location: ../index.php");
    exit();
}

// Fetch unresolved alerts
$alerts_query = mysqli_query($con, "SELECT * FROM alerts WHERE status = 'unresolved' ORDER BY timestamp DESC");

// Fetch system logs
$logs_query = mysqli_query($con, "SELECT * FROM system_logs ORDER BY timestamp DESC");
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOC Analyst Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            color: #1abc9c;
            text-align: center;
            margin-bottom: 40px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .card h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #ecf0f1;
        }

        .alert {
            background-color: #e74c3c;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .log {
            background-color: #34495e;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .ip-info {
            font-weight: bold;
        }

        .btn {
            background-color: #1abc9c;
            color: #fff;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 6px;
            margin-top: 20px;
            display: block;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #16a085;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #2c3e50;
            color: #ecf0f1;
            margin: 0;
        }

        .container {
            max-width: 900px;
            width: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 32px;
            color: #1abc9c;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .card {
            background-color: #34495e;
            border-radius: 8px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .alert {
            background-color: #e74c3c;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            color: white;
        }

        .log {
            background-color: #2c3e50;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #1abc9c;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background-color: #16a085;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Welcome, SOC Analyst</h1>

        <div class="grid">
            <!-- Unresolved Alerts -->
            <div class="card">
                <h2>Unresolved Alerts</h2>
                <?php while ($alert = mysqli_fetch_assoc($alerts_query)) { ?>
                <div class="alert">
                    <p><span class="ip-info">IP Address:</span>
                        <?php echo $alert['ip_address']; ?>
                    </p>
                    <p><span class="ip-info">Alert Type:</span>
                        <?php echo $alert['alert_type']; ?>
                    </p>
                    <p><span class="ip-info">Timestamp:</span>
                        <?php echo $alert['timestamp']; ?>
                    </p>
                </div>
                <?php } ?>
            </div>

            <!-- System Logs -->
            <div class="card">
                <h2>System Logs</h2>
                <?php while ($log = mysqli_fetch_assoc($logs_query)) { ?>
                <div class="log">
                    <p><span class="ip-info">IP Address:</span>
                        <?php echo $log['ip_address']; ?>
                    </p>
                    <p><span class="ip-info">Log Type:</span>
                        <?php echo $log['log_type']; ?>
                    </p>
                    <p><span class="ip-info">Timestamp:</span>
                        <?php echo $log['timestamp']; ?>
                    </p>
                    <p><span class="ip-info">Description:</span>
                        <?php echo $log['description']; ?>
                    </p>
                </div>
                <?php } ?>
            </div>
        </div>

        <!-- Logout Button -->
        <div>
            <a href="../php/logout.php" class="btn">Log Out</a>
        </div>
    </div>
</body>

</html>