<?php
// Get user input from the form (pay1.php)
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$currency = $_POST['currency'] ?? 'USD';

// Fixed amounts
$usd_amount = 2 * 100; // Razorpay requires amount in cents/paise
$inr_amount = 170 * 100;
$converted_amount = ($currency == "USD") ? $usd_amount : $inr_amount;

// Generate a unique order ID
$order_id = uniqid("ORD_");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment...</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body onload="startPayment()">

<script>
function startPayment() {
    var options = {
        "key": "rzp_test_JeXlTqk8Zeui9U", // Replace with your Razorpay API key
        "amount": <?php echo $converted_amount; ?>,
        "currency": "<?php echo $currency; ?>",
        "name": "Acme Corp",
        "description": "Subscription Purchase",
        "image": "https://example.com/logo.jpg",
        "order_id": "<?php echo $order_id; ?>",
        "handler": function (response) {
            // Handle successful payment and redirect directly to app1.php
            if (response.razorpay_payment_id) {
                alert("Payment successful! Redirecting to your dashboard.");
                window.location.href = "app1.php"; // Redirect to app1.php on success
            } else {
                alert("Payment failed. Please try again.");
            }
        },
        "prefill": {
            "name": "<?php echo $name; ?>",
            "email": "<?php echo $email; ?>",
            "contact": "<?php echo $phone; ?>"
        },
        "theme": {
            "color": "#F37254"
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.open();
}
</script>

</body>
</html>
