<?php
// Railway MySQL connection URL
$connection_url = "mysql://username:password@host:port/database"; // Replace with actual details

// Parse the connection URL
$parsed_url = parse_url($connection_url);
$host = $parsed_url["host"];
$port = $parsed_url["port"];
$username = $parsed_url["user"];
$password = $parsed_url["pass"];
$dbname = ltrim($parsed_url["path"], "/");

// Connect to the MySQL database
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get payment details from pay1script.php
$payment_id = $_POST['payment_id'] ?? '';
$order_id = $_POST['order_id'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';

if (!empty($payment_id) && !empty($order_id)) {
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
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid payment details!"]);
}
?>
