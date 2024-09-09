<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <main class="w-full h-min-screen flex justify-center items-center">
        <section class="w-96 rounded-lg shadow-xl p-10 border border-gray-600">
            <header class="mb-5">
                <h1 class="text-2xl font-bold">Verify Email</h1>
            </header>
            <div>
                <p>Welcome, {{ $full_name }}!</p>
                <p>Verification code: {{ $otp }}</p>
            </div>
        </section>
    </main>
</body>
</html>