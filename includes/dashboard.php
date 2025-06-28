<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../model/conn.php';

$sql = "SELECT COUNT(*) AS total FROM mentors WHERE create_date >= DATE(NOW()) - INTERVAL 7 DAY";
$result = mysqli_query($conn, $sql);
$mentors_last_week = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM mentors WHERE create_date >= DATE(NOW()) - INTERVAL 14 DAY AND create_date < DATE(NOW()) - INTERVAL 7 DAY";
$result = mysqli_query($conn, $sql);
$mentors_previous_week = mysqli_fetch_assoc($result)['total'];

$mentors_increase = ($mentors_previous_week > 0) ? (($mentors_last_week - $mentors_previous_week) / $mentors_previous_week) * 100 : ($mentors_last_week > 0 ? 100 : 0);
$mentors_increase = round($mentors_increase);

$sql = "SELECT COUNT(*) AS total FROM mentors";
$result = mysqli_query($conn, $sql);
$mentors = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM students WHERE create_date >= DATE(NOW()) - INTERVAL 7 DAY";
$result = mysqli_query($conn, $sql);
$students_last_week = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM students WHERE create_date >= DATE(NOW()) - INTERVAL 14 DAY AND create_date < DATE(NOW()) - INTERVAL 7 DAY";
$result = mysqli_query($conn, $sql);
$students_previous_week = mysqli_fetch_assoc($result)['total'];

$students_increase = ($students_previous_week > 0) ? (($students_last_week - $students_previous_week) / $students_previous_week) * 100 : ($students_last_week > 0 ? 100 : 0);
$students_increase = round($students_increase);

$sql = "SELECT COUNT(*) AS total FROM students";
$result = mysqli_query($conn, $sql);
$students = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM groups WHERE create_date >= DATE(NOW()) - INTERVAL 7 DAY";
$result = mysqli_query($conn, $sql);
$groups_last_week = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM groups WHERE create_date >= DATE(NOW()) - INTERVAL 14 DAY AND create_date < DATE(NOW()) - INTERVAL 7 DAY";
$result = mysqli_query($conn, $sql);
$groups_previous_week = mysqli_fetch_assoc($result)['total'];

$groups_increase = ($groups_previous_week > 0) ? (($groups_last_week - $groups_previous_week) / $groups_previous_week) * 100 : ($groups_last_week > 0 ? 100 : 0);
$groups_increase = round($groups_increase);

$sql = "SELECT COUNT(*) AS total FROM groups";
$result = mysqli_query($conn, $sql);
$groups = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM batches WHERE create_date >= DATE(NOW()) - INTERVAL 7 DAY";
$result = mysqli_query($conn, $sql);
$batches_last_week = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM batches WHERE create_date >= DATE(NOW()) - INTERVAL 14 DAY AND create_date < DATE(NOW()) - INTERVAL 7 DAY";
$result = mysqli_query($conn, $sql);
$batches_previous_week = mysqli_fetch_assoc($result)['total'];

$batches_increase = ($batches_previous_week > 0) ? (($batches_last_week - $batches_previous_week) / $batches_previous_week) * 100 : ($batches_last_week > 0 ? 100 : 0);
$batches_increase = round($batches_increase);

$sql = "SELECT COUNT(*) AS total FROM batches";
$result = mysqli_query($conn, $sql);
$batches = mysqli_fetch_assoc($result)['total'];
?>
<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-primary">
							<div class="card-body  p-4">
								<div class="media">
									<span class="me-3">
										<i class="fas fa-user-graduate"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Total Students</p>
										<h3 class="text-white"><?php echo $students; ?></h3>
<div class="progress mb-2 bg-secondary">
                                            <div class="progress-bar progress-animated bg-light" style="width: <?php echo $students_increase; ?>%"></div>
                                        </div>
<small><?php echo $students_increase; ?>% Increase in Last Week</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-success">
							<div class="card-body  p-4">
								<div class="media">
									<span class="me-3">
										<i class="flaticon-381-user-9"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Total Mentors</p>
										<h3 class="text-white"><?php echo $mentors; ?></h3>
										<div class="progress mb-2 bg-secondary">
                                            <div class="progress-bar progress-animated bg-light" style="width: <?php echo $mentors_increase; ?>%"></div>
                                        </div>
										<small><?php echo $mentors_increase; ?>% Increase in Last Week</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-info">
							<div class="card-body p-4">
								<div class="media">
									<span class="me-3">
										<i class="fas fa-users"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Total Groups</p>
										<h3 class="text-white"><?php echo $groups; ?></h3>
										<div class="progress mb-2 bg-primary">
                                            <div class="progress-bar progress-animated bg-light" style="width: <?php echo $groups_increase; ?>%"></div>
                                        </div>
										<small><?php echo $groups_increase; ?>% Increase in Last Week</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-warning">
							<div class="card-body p-4">
								<div class="media">
									<span class="me-3">
										<i class="fas fa-graduation-cap"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Total Batches</p>
										<h3 class="text-white"><?php echo $batches; ?></h3>
										<div class="progress mb-2 bg-primary">
                                            <div class="progress-bar progress-animated bg-light" style="width: <?php echo $batches_increase; ?>%"></div>
                                        </div>
										<small><?php echo $batches_increase; ?>% Increase in Last Week</small>
									</div>
								</div>
							</div>
						</div>
                    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Batchs Status</h4>
                </div>
                <div class="card-body">
                    <canvas id="batchStatusChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Students Status</h4>
                </div>
                <div class="card-body">
                    <canvas id="studentStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Students per Batch</h4>
                </div>
                <div class="card-body">
                    <canvas id="studentsPerBatchChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Students per Group</h4>
                </div>
                <div class="card-body">
                    <canvas id="studentsPerGroupChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../views/vendor/apexchart/apexchart.js"></script>
    <script>
        // Function to fetch data and create the batch status chart
        function createBatchStatusChart() {
            fetch('../apis/batchesApi.php?action=getBatchStatusCounts&_=' + Date.now())
                .then(response => response.json())
                .then(data => {
                    const labels = Object.keys(data);
                    const values = Object.values(data);

                    const ctx = document.getElementById('batchStatusChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Batch Status',
                                data: values,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                });
        }

        // Function to fetch data and create the student status chart
        function createStudentStatusChart() {
            fetch('../apis/studentsApi.php?action=getStudentStatusCounts')
                .then(response => response.json())
                .then(data => {
                    const labels = Object.keys(data);
                    const values = Object.values(data);

                    const ctx = document.getElementById('studentStatusChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Student Status',
                                data: values,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                });
        }

        // Call the functions to create the charts
        createBatchStatusChart();
        createStudentStatusChart();

        // Function to fetch data and create the students per batch chart
        function createStudentsPerBatchChart() {
            fetch('../apis/batchesApi.php?action=getStudentsCountPerBatch&_=' + Date.now())
                .then(response => response.json())
                .then(data => {
                    const labels = Object.keys(data);
                    const values = Object.values(data);

                    const ctx = document.getElementById('studentsPerBatchChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Number of Students',
                                data: values,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        }

        // Function to fetch data and create the students per group chart
        function createStudentsPerGroupChart() {
            fetch('../apis/groupsApi.php?action=getStudentsCountPerGroup&_=' + Date.now())
                .then(response => response.json())
                .then(data => {
                    const labels = Object.keys(data);
                    const values = Object.values(data);

                    const ctx = document.getElementById('studentsPerGroupChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Number of Students',
                                data: values,
                                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        }

        // Call the new functions to create the charts
        createStudentsPerBatchChart();
        createStudentsPerGroupChart();
    </script>
