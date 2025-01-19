<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template 1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- Email Container -->
    <div class="w-full max-w-3xl mx-auto my-10">
        <!-- Card -->
        <div class="card bg-base-100 shadow-lg rounded-lg">
            <!-- Header -->
            <div class="card-body bg-primary text-primary-content p-6 rounded-t-lg">
                <h1 class="text-2xl font-bold">Welcome to Our Service</h1>
                <p class="text-lg">We're excited to have you on board!</p>
            </div>
            <!-- Body -->
            <div class="card-body p-6">
                <p class="text-lg">
                    Hello, <br><br>
                    Thank you for signing up for our service! Below are your account details:
                </p>
                <ul class="list-disc list-inside my-4">
                    <li><strong>Username:</strong> johndoe@example.com</li>
                    <li><strong>Password:</strong> ********</li>
                </ul>
                <p class="mb-4">
                    Please click the button below to verify your email address and complete your registration.
                </p>
                <!-- Button -->
                <div class="flex justify-center">
                    <a href="#" class="btn btn-primary">Verify Email</a>
                </div>
            </div>
            <!-- Footer -->
            <div class="card-body bg-primary text-center p-4 rounded-b-lg">
                <p>{{__("If you did not sign up for this account, please ignore this email.")}}</p>
                <p>© 2024 Company Name. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
