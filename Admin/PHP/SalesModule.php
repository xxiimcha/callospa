<?php
include "callospa_admin_database.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
            SUM(total_cost) AS total_sales,
            SUM(deposit_amount) AS total_deposits,
            SUM(remaining_balance) AS total_remaining_balance
        FROM 
            approved_reservations
        WHERE 
            check_in_date IS NOT NULL";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

$conn->close();

echo json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Callospa Resort Sales Summary Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #myChart {
            max-width: 600px;
            margin: auto;
        }

        #loading {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include 'Sidebar.php'; ?>
    <section id="content">
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Sales Summary Chart</h1>
                    <ul class="links">
                        <li><a href="#">Room Reservations Dashboard</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="AdministratorPage.php">Home</a></li>
                    </ul>
                </div>
            </div>
            <canvas id="myChart"></canvas>
            <div id="loading">Loading data...</div> <!-- Loading indicator -->
        </main>
    </section>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        let myChart;
        const loadingIndicator = document.getElementById('loading');

        function fetchData() {
            loadingIndicator.style.display = 'block'; // Show loading indicator
            fetch('fetch_sales_data.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    loadingIndicator.style.display = 'none'; // Hide loading indicator
                    if (data && data.total_sales !== null && data.total_deposits !== null && data.total_remaining_balance !== null) {
                        if (myChart) {
                            myChart.destroy();
                        }
                        myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Total Sales', 'Total Deposits', 'Remaining Balance'],
                                datasets: [{
                                    label: 'Amount ($)',
                                    data: [data.total_sales || 0, data.total_deposits || 0, data.total_remaining_balance || 0],
                                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    } else {
                        console.error("Invalid data received", data);
                    }
                })
                .catch(error => {
                    loadingIndicator.style.display = 'none'; // Hide loading indicator
                    console.error('Error fetching data:', error);
                });
        }

        // Fetch data on page load
        fetchData();

        // Optional: Fetch data every 10 seconds
        setInterval(fetchData, 10000);
    </script>
</body>

</html>
