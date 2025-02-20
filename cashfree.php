<?php
header("Content-Type: application/json");

// ✅ Replace with your **LIVE** Cashfree credentials
$clientId = "913111295ffc1c72c2272f8c34111319";  
$clientSecret = "cfsk_ma_prod_c4578b71a16f3c67629ca0266cb380de_b3769645";

// ✅ LIVE Cashfree API endpoint
$apiUrl = "https://api.cashfree.com/pg/orders";

// ✅ Generate a unique Order ID
$orderId = "ORDER_" . time();

// ✅ Order Details (Modify as needed)
$orderData = [
    "order_id" => $orderId,
    "order_amount" => 499,  // Amount in INR
    "order_currency" => "INR",
    "customer_details" => [
        "customer_id" => "12345",
        "customer_email" => "test@example.com",
        "customer_phone" => "9876543210"
    ],
    "order_note" => "Test Order",
    "order_meta" => [
     "return_url" => "https://tube-trend.onrender.com/"// ✅ LIVE return URL
    ]
];

// ✅ Convert data to JSON
$orderJson = json_encode($orderData);

// ✅ Set API headers (LIVE Mode)
$headers = [
    "Content-Type: application/json",
    "x-client-id: $clientId",
    "x-client-secret: $clientSecret"
];

// ✅ Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $orderJson);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// ✅ Execute API request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// ✅ Log API Response for Debugging
file_put_contents("cashfree_debug.log", "Response: " . print_r($response, true) . "\n", FILE_APPEND);

// ✅ If cURL has an error, return it
if ($error) {
    echo json_encode(["status" => "error", "message" => "cURL Error: $error"]);
    exit;
}

// ✅ Decode API response
$responseData = json_decode($response, true);

// ✅ Handle Cashfree API errors
if ($httpCode != 200 || !isset($responseData["payment_session_id"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Cashfree API Error",
        "http_code" => $httpCode,
        "response" => $responseData
    ]);
    exit;
}

// ✅ Return payment session ID to frontend
echo json_encode(["status" => "success", "payment_session_id" => $responseData["payment_session_id"]]);
?>
