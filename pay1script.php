<?php
// Get user input from pay1.php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$currency = $_POST['currency'] ?? 'USD';

// Fixed amounts
$usd_amount = 6 * 100; // Razorpay requires amount in cents/paise
$inr_amount = 524 * 100;
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
            // Send payment details to subscription.php for database entry
            fetch("subscription.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    "payment_id": response.razorpay_payment_id,
                    "order_id": "<?php echo $order_id; ?>",
                    "name": "<?php echo $name; ?>",
                    "email": "<?php echo $email; ?>",
                    "phone": "<?php echo $phone; ?>"
                })
            })
            .then(res => res.json()) // Expecting JSON response
            .then(data => {
                if (data.status == "success") {
                    alert("Payment successful! Your Subscription ID: " + data.sub_id);
                    window.location.href = "login.php"; // Redirect to login
                } else {
                    alert("Error storing subscription: " + data.message);
                }
            })
            .catch(error => {
                alert("Request failed: " + error);
            });
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
