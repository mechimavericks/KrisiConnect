<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>कृषि कनेक्ट</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body class="bg-[#0d1727] text-white font-sans">

<div class="max-w-lg mx-auto p-5">
    <header class="flex justify-between items-center mb-5">
        <h1 class="text-xl font-bold">कृषि कनेक्ट</h1>
    </header>

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <section class="mb-5">
        <div class="flex overflow-x-scroll space-x-3 no-scrollbar">
            <form action="{{ route('marketplace.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="खोज्नुहोस्..."
                       class="p-2 bg-[#1a2a3b] border border-gray-700 rounded-sm text-sm">
                <button type="submit" class="bg-green-500 text-white py-1 px-3 rounded-sm text-sm ml-2">
                    खोज्नुहोस्
                </button>
            </form>
        </div>
    </section>
    
   

    

    @include('footer')
</div>

 





</body>
</html>
