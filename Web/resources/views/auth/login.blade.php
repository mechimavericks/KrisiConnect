<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Krishi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center" style="background-image: url('/image1.png');">
<div class="flex flex-col items-center justify-between h-screen bg-black bg-opacity-40 text-white">
    <!-- Welcome Section -->
    <div class="text-center pt-16">
        <h1 class="font-extralight mb-2">तपाईलाई</h1>
        <h2 class="text-6xl font-extrabold mb-2">Krishi Connect</h2>
        <p class="font-extralight mb-6">मा स्वागत छ।</p>
    </div>

    <!-- Login Section with Google and Form -->
    <div class="bg-white p-4 pt-10 shadow-lg text-center flex flex-col justify-evenly items-center w-full opacity-80 h-auto" style="border-radius:60px 60px 0px 0px;">
        <p class="text-black text-2xl font-bold mb-4">Krishi Connect <span class="font-light">चलाउन लग ईन गर्नुहोस्।</span></p>

        <!-- Google Sign-in Button -->
       

        <!-- Laravel Login Form -->
        <form action="{{ route('login') }}" method="POST" class="w-8/12">
            @csrf
            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="sr-only">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Your Email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 text-black">
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" placeholder="Your Password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 text-black">
            </div>

            <!-- Login Button -->
            <div class="mb-4">
                <button type="submit" class="w-full px-4 py-2 bg-green-600 font-bold text-white rounded-lg shadow-sm hover:bg-blue-800">Login</button>
            </div>
        </form>
        <a href="{{ route('auth.google') }}" class="flex bg-blue-600 items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm  hover:bg-blue-800 h-12 w-8/12 mb-6">
            <img src="https://cdn2.hubspot.net/hubfs/53/image8-2.jpg" alt="Google Logo" class="h-10 w-12 object-contain mr-2">
            <span class="font-bold text-white">Sign up with Google</span>
        </a>

        <!-- Google Sign-in Privacy Note -->
        <p class="text-gray-500 text-xs mt-4">तपाइँको गुगल खाता सुरक्षित हुन्छ।</p>
    </div>
</div>
</body>
</html>
