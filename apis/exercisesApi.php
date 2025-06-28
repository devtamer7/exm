<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../model/conn.php'; // Include your database connection

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'getExerciseCounts':
        getExerciseCounts($conn);
        break;
    case 'uploadExercise':
        uploadExercise($conn);
        break;
    case 'uploadExerciseFiles': // For Dropzone.js direct file uploads
        uploadExerciseFiles($conn);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

function getExerciseCounts($conn) {
    $student_id = $_GET['student_id'] ?? null;

    if (!$student_id) {
        echo json_encode(['status' => 'error', 'message' => 'Student ID is required.']);
        return;
    }

    $counts = [
        'total' => 0,
        'approved' => 0,
        'rejected' => 0
    ];

    // Total Exercises
    $sql_total = "SELECT COUNT(*) AS total FROM exercises WHERE student_id = ?";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("i", $student_id);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $counts['total'] = $result_total->fetch_assoc()['total'];
    $stmt_total->close();

    // Approved Exercises
    $sql_approved = "SELECT COUNT(*) AS approved FROM exercises WHERE student_id = ? AND status = 'approved'";
    $stmt_approved = $conn->prepare($sql_approved);
    $stmt_approved->bind_param("i", $student_id);
    $stmt_approved->execute();
    $result_approved = $stmt_approved->get_result();
    $counts['approved'] = $result_approved->fetch_assoc()['approved'];
    $stmt_approved->close();

    // Rejected Exercises
    $sql_rejected = "SELECT COUNT(*) AS rejected FROM exercises WHERE student_id = ? AND status = 'rejected'";
    $stmt_rejected = $conn->prepare($sql_rejected);
    $stmt_rejected->bind_param("i", $student_id);
    $stmt_rejected->execute();
    $result_rejected = $stmt_rejected->get_result();
    $counts['rejected'] = $result_rejected->fetch_assoc()['rejected'];
    $stmt_rejected->close();

    echo json_encode(['status' => 'success', 'data' => $counts]);
}

function uploadExercise($conn) {
    $student_id = $_POST['student_id'] ?? null;
    $subject = $_POST['subject'] ?? null;
    $note = $_POST['note'] ?? null;
    $type = $_POST['type'] ?? null; // 'file' or 'github_repo'
    $github_repo_link = $_POST['github_repo_link'] ?? null;

    if (!$student_id || !$subject || !$type) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        return;
    }

    if ($type === 'github_repo') {
        if (!$github_repo_link) {
            echo json_encode(['status' => 'error', 'message' => 'GitHub repository link is required for GitHub upload.']);
            return;
        }

        $sql = "INSERT INTO exercises (student_id, subject, note, type, github_repo_link) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $student_id, $subject, $note, $type, $github_repo_link);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Exercise submitted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        // This function is primarily for non-file data when files are handled by uploadExerciseFiles
        // If files are expected here, it means Dropzone.js autoProcessQueue was false and files are sent with form
        // For now, we assume files are handled by uploadExerciseFiles
        echo json_encode(['status' => 'error', 'message' => 'File upload should be handled by uploadExerciseFiles endpoint.']);
    }
}

function uploadExerciseFiles($conn) {
    $student_id = $_POST['student_id'] ?? null;
    $subject = $_POST['subject'] ?? null;
    $note = $_POST['note'] ?? null;
    $type = $_POST['type'] ?? 'file'; // Should always be 'file' for this endpoint

    if (!$student_id || !$subject || !isset($_FILES['exercise_files'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields or files.']);
        return;
    }

    $upload_dir = '../uploads/exercises/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $uploaded_file_paths = [];
    $errors = [];

    foreach ($_FILES['exercise_files']['name'] as $key => $name) {
        $tmp_name = $_FILES['exercise_files']['tmp_name'][$key];
        $error = $_FILES['exercise_files']['error'][$key];
        $file_size = $_FILES['exercise_files']['size'][$key];
        $file_type = $_FILES['exercise_files']['type'][$key];

        if ($error === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($name, PATHINFO_EXTENSION);
            $new_file_name = uniqid('exercise_') . '.' . $file_extension;
            $destination = $upload_dir . $new_file_name;

            // Basic file type validation (can be more robust)
            $allowed_extensions = ['html', 'css', 'js', 'php', 'json', 'txt', 'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                $errors[] = "File type not allowed for {$name}.";
                continue;
            }

            if (move_uploaded_file($tmp_name, $destination)) {
                $uploaded_file_paths[] = $destination;
            } else {
                $errors[] = "Failed to move uploaded file {$name}.";
            }
        } else {
            $errors[] = "Upload error for {$name}: " . $error;
        }
    }

    if (!empty($uploaded_file_paths)) {
        $file_paths_json = json_encode($uploaded_file_paths);
        $sql = "INSERT INTO exercises (student_id, subject, note, type, file_paths) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $student_id, $subject, $note, $type, $file_paths_json);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Exercise submitted successfully.', 'errors' => $errors]);
        } else {
            // If database insertion fails, clean up uploaded files
            foreach ($uploaded_file_paths as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error, 'errors' => $errors]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No files were uploaded or all uploads failed.', 'errors' => $errors]);
    }
}

$conn->close();
?>