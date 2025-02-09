<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checkout Form</title>
   <style>
           body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 20px;
        color: #333;
    }
    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 50px auto;
    }
    label {
        font-size: 16px;
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }
    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    button {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }
    button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
    <h2>Checkout Form</h2>
    <form method="POST" action="pay1script.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="currency">Select Currency:</label>
        <select id="currency" name="currency" required onchange="updateAmount()">
            <option value="USD">USD (US Dollar)</option>
            <option value="INR">INR (Indian Rupee)</option>
        </select>

        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required readonly>

        <button type="submit">Pay Now</button>
    </form>

    <script>
        function updateAmount() {
            let currency = document.getElementById("currency").value;
            let amountField = document.getElementById("amount");

            // Fixed amounts based on selected currency
            let prices = {
                "USD": "2 USD",
                "INR": "170 INR"
            };

            amountField.value = prices[currency]; // Update amount field
        }

        // Set default value on page load
        document.addEventListener("DOMContentLoaded", updateAmount);
    </script>
</body>
</html>