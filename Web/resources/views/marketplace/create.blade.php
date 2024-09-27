<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>नयाँ उत्पादन थप्नुहोस्</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body class="bg-[#0d1727] text-white font-sans min-h-screen flex flex-col">

<div class="max-w-md mx-auto p-6 bg-[#1a2749] rounded-lg mt-10">
    <!-- फर्कनुहोस् बटन -->
    <a href="{{ url()->previous() }}" class="flex items-center text-gray-300 hover:text-white mb-6">
        <i class='bx bx-arrow-back text-xl'></i>
        <span class="ml-2">फर्कनुहोस्</span>
    </a>

    <h1 class="text-2xl font-semibold mb-4">नयाँ उत्पादन थप्नुहोस्</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('marketplace.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-1">उत्पादनको नाम</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full p-2 rounded-lg bg-[#2e3a50] text-white border-none outline-none" placeholder="उत्पादनको नाम प्रविष्ट गर्नुहोस्" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium mb-1">विवरण</label>
            <textarea id="description" name="description" rows="4" class="w-full p-2 rounded-lg bg-[#2e3a50] text-white border-none outline-none" placeholder="उत्पादनको विवरण प्रविष्ट गर्नुहोस्">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium mb-1">मूल्य</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" class="w-full p-2 rounded-lg bg-[#2e3a50] text-white border-none outline-none" placeholder="मूल्य प्रविष्ट गर्नुहोस्" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium mb-1">उत्पादन छवि (वैकल्पिक)</label>
            <input type="file" id="image" name="image" class="w-full p-2 rounded-lg bg-[#2e3a50] text-white border-none outline-none">
        </div>

        <button type="submit" class="bg-[#4CAF50] text-white p-3 rounded-lg w-full">उत्पादन सिर्जना गर्नुहोस्</button>

    </form>

</div>
@include('footer')

</body>
</html>
