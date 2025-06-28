<?php
session_start();
// require_once '../model/conn.php'; // Adjust path as necessary

// Connection Code 

function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "xem"; // Assuming 'xem' is your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Connection Code End

header('Content-Type: application/json'); // Set content type to JSON

$response = ['success' => false, 'message' => 'Invalid request.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']);

    if (empty($email) || empty($password)) {
        $response['message'] = 'Email and password are required.';
        echo json_encode($response);
        exit();
    }

    $conn = connectDB();

    $loggedIn = false;
    $redirectUrl = '';
    $role = '';
    $userId = '';

    // Try to find user in admins table
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $loggedIn = true;
            $role = 'admin';
            $userId = $user['id'];
            $redirectUrl = 'views/index.php';
        }
    }
    $stmt->close();

    // Try to find user in mentors table
    if (!$loggedIn) {
        $stmt = $conn->prepare("SELECT id, mentorPassword FROM mentors WHERE mentorEmail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['mentorPassword'])) { // Corrected column name
                $loggedIn = true;
                $role = 'mentor';
                $userId = $user['id'];
                $redirectUrl = 'views/mentor_dashboard.php';
            }
        }
        $stmt->close();
    }

    // Try to find user in students table
    if (!$loggedIn) {
        $stmt = $conn->prepare("SELECT id, studentPassword FROM students WHERE studentEmail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['studentPassword'])) { // Corrected column name
                $loggedIn = true;
                $role = 'student';
                $userId = $user['id'];
                $redirectUrl = 'views/student_dashboard.php';
            }
        }
        $stmt->close();
    }

    $conn->close();

    if ($loggedIn) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = $role;
        if ($remember_me) {
            setcookie('remember_me', $userId . '|' . $role, time() + (86400 * 30), "/"); // 30 days
        }
        $response = ['success' => true, 'redirect' => $redirectUrl];
    } else {
        $response['message'] = 'Invalid email or password.';
    }
    echo json_encode($response);
    exit();
} else {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit();
}
?>