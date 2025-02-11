<?php
// Fetch Database Connection URL from environment variable
$connection_url = getenv("DATABASE_URL");

if (!$connection_url) {
    die(json_encode(["status" => "error", "message" => "Database connection URL not set."]));
}

// Parse the connection URL
$parsed_url = parse_url($connection_url);
$host = $parsed_url["host"];
$port = $parsed_url["port"] ?? "3306"; // Default MySQL port
$username = $parsed_url["user"];
$password = $parsed_url["pass"];
$dbname = ltrim($parsed_url["path"], "/");

// Connect to MySQL database using PDO
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $e->getMessage()]));
}

// Get payment details from pay1script.php
$payment_id = trim($_POST['payment_id'] ?? '');
$order_id = trim($_POST['order_id'] ?? '');
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// Validate required fields
if (empty($payment_id) || empty($order_id) || empty($name) || empty($email) || empty($phone)) {
    die(json_encode(["status" => "error", "message" => "All fields are required!"]));
}

try {
    // Convert order_id to sub_id (subscription ID)
    $sub_id = "SUB_" . substr($payment_id, -8);

    // Store in the database
    $stmt = $conn->prepare("INSERT INTO subscriptions (sub_id, order_id, name, email, phone) VALUES (:sub_id, :order_id, :name, :email, :phone)");
    $stmt->execute([
        ':sub_id' => $sub_id,
        ':order_id' => $order_id,
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone
    ]);

    // Show sub_id to the user
    echo json_encode(["status" => "success", "sub_id" => $sub_id]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>
