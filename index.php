<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: linear-gradient(to right, #1a2a6c, #b21f1f, #fdbb2d);
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
            min-height: 400px;
            width: 375px;
            margin: 0 auto;
        }
        .btn-dark-golden {
            background: linear-gradient(45deg, #daa520, #b8860b);
            color: white;
            font-weight: bold;
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
            padding: 12px 24px;
            font-size: 20px;
        }
        .btn-dark-golden:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }
        .plan-list {
            text-align: left;
            padding-left: 20px;
            font-size: 20px;
        }
        .plan-list li::before {
            content: "\2713";
            color: #b8860b;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }
        .recommended {
            border: 4px solid #007bff;
            position: relative;
        }
        .recommended::before {
            content: "Recommended";
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #007bff;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
        }
        .discount {
            color: red;
            font-weight: bold;
            font-size: 20px;
        }
        .plan-list p {
    margin-bottom: 10px; /* Adjust spacing as needed */
                     }
    </style>
</head>
<body>
    <section class="container text-center py-5">
        <h1 class="mb-4">Choose Your Plan</h1>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <h2>Free Plan 🌱</h2>
                    <p><b>$0/month</b></p>
                    <div class="plan-list">
                      <p>✅ Only Video Title & Views</p>
                      <p>✅ Fetch Only 1000 Videos</p>
                      <p>❌ Not Able To Select Region</p>
                      <p>❌ No AI Agent For Research</p>
                      <p>❌ No Deep Dive For Topic</p>
                      <p>❌ No Advanced Analytics</p>
                      <p>✅ Basic Customer Support</p>
                      <p>✅ Join Our Community</p>
                    </div>
                    <a href="https://basicytresearcher.streamlit.app/" class="btn btn-dark-golden">Free Plan</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card recommended">
                    <h2>Pro Plan 🚀<br> <span class="discount">40% OFF</span></h2>
                    <p><del>$10</del> <strong>$6/month</strong></p>
                    <ul class="plan-list">

                      <p>✅ Get Also Video Url</p>
                      <p>✅ Fetch 10,000 videos</p>
                      <p>✅ Get Deep Dive In to Topic</p>
                      <p>✅ Get Advanced Analytics</p>
                      <p>✅ Able To Select Any Region</p>
                      <p>✅ AI Agent For Research</p>
                      <p>✅ AI Agent For Transcription</p>
                    </ul>
                    <a href="rks.html" class="btn btn-dark-golden">Get Pro Plan</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <h2>Advance Plan 💼 <span class="discount">30% OFF</span></h2>
                    <p><del>$30</del> <strong>$21/month</strong></p>
                    <ul class="plan-list">
                        <li>Includes everything in the Pro Plan plus premium benefits</li>
                        <li>24/7 dedicated customer support with instant response time</li>
                        <li>Custom solutions tailored to fit your unique business needs</li>
                    </ul>
                    <a href="rks1.html" class="btn btn-dark-golden">Get Advance Plan</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
