<?php
session_start(); // Start session to manage login state

// Fetch Database Connection URL from environment variable
$connection_url = getenv("DATABASE_URL");

if (!$connection_url) {
    die("Database connection URL not set.");
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
    die("Database connection failed: " . $e->getMessage());
}

// Handle AJAX login request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    $sub_id = trim($_POST['sub_id'] ?? '');

    if (!empty($sub_id)) {
        // Validate sub_id in the database
        $stmt = $conn->prepare("SELECT * FROM subscriptions WHERE sub_id = :sub_id");
        $stmt->bindParam(":sub_id", $sub_id, PDO::PARAM_STR);
        $stmt->execute();
        $subscription = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($subscription) {
            $_SESSION['sub_id'] = $sub_id;
            echo json_encode(["status" => "success", "message" => "Login successful! Redirecting..."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid Subscription ID."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Please enter a Subscription ID."]);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script>
        function login() {
            let subId = document.getElementById("sub_id").value.trim();
            let resultMessage = document.getElementById("result-message");

            if (subId === "") {
                resultMessage.innerHTML = "<p style='color:red;'>Please enter a Subscription ID.</p>";
                return;
            }

            fetch("login.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "ajax=1&sub_id=" + encodeURIComponent(subId)
            })
            .then(response => response.json())
            .then(data => {
                resultMessage.innerHTML = `<p style="color:${data.status === 'success' ? 'green' : 'red'};">${data.message}</p>`;
                if (data.status === "success") {
                    setTimeout(() => window.location.href = "app.php", 1500);
                }
            })
            .catch(error => {
                resultMessage.innerHTML = "<p style='color:red;'>An error occurred. Please try again.</p>";
                console.error("Error:", error);
            });
        }
    </script>
</head>
<body>
    <h2>Login</h2>
    <div id="result-message"></div>
    
    <form onsubmit="event.preventDefault(); login();">
        <label for="sub_id">Subscription ID:</label>
        <input type="text" id="sub_id" name="sub_id" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
