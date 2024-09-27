<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Krishi Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body class="bg-[#0d1727] text-white font-sans">

<div class="max-w-4xl mx-auto p-5">
    <!-- Product Details -->
    <div class=" text-white-900 rounded-lg shadow-lg overflow-hidden">
        @if ($product->image)
            <img src="uploads/gallery/gallery_file/{{$product->image}}" alt="{{ $product->name }}" class="w-full h-80 object-cover">
        @else
            <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                <span class="text-white-500">No Image</span>
            </div>
        @endif
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
            <p class="text-lg mb-4">{{ $product->description }}</p>
            <p class="text-xl font-semibold mb-4">Price: ${{ $product->price }}</p>
            <p class="text-md text-gray-700 mb-4">Seller: {{ $product->user->name }}</p>
            <div class="flex space-x-4 mt-4">
                <a href="{{ route('marketplace.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Back to Marketplace</a>
                <a href="tel:9824027168" class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition">Call Seller</a>

            </div>
        </div>
    </div>
    <!-- Product Details -->

    @include('footer')
</div>

<!-- Footer Navigation -->

</body>
</html>
