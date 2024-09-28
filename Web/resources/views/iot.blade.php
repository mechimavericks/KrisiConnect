<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soil Moisture Measurement - Krishi Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('ICON.PNG') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
</head>
<body class="bg-[#0d1727] text-white font-sans flex items-center justify-center min-h-screen">
<div class="max-w-sm mx-auto p-5">
    <header class="mb-6 text-center">
        <h1 class="text-2xl font-bold mb-4">माटोको आर्द्रता मापन गर्नुहोस्</h1>
    </header>

    <div class="text-center">
        <button id="fetchMoistureData" class="mt-4 px-4 py-2 bg-blue-500 rounded-lg">
            आर्द्रता मापन गर्नुहोस्
        </button>

        <div id="loadingSpinner" class="hidden mt-4">
            <i class="bx bx-loader-alt animate-spin text-4xl"></i>
            <p>Processing...</p>
        </div>

        <div id="moistureResults" class="mt-4 text-left bg-gray-800 p-4 rounded-lg shadow-lg hidden">
            <h3 class="text-lg font-semibold mb-2">Moisture Level</h3>
            <p id="moistureLevel" class="mb-2"></p>
            <p id="moistureAdvice"></p>
        </div>

        <div id="errorMessage" class="hidden mt-4 text-red-500">
            <p>Failed to fetch the data. Please try again.</p>
        </div>
    </div>

    @include('footer')
</div>

<script>
    const fetchMoistureDataButton = document.getElementById('fetchMoistureData');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const moistureResults = document.getElementById('moistureResults');
    const moistureLevel = document.getElementById('moistureLevel');
    const moistureAdvice = document.getElementById('moistureAdvice');
    const errorMessage = document.getElementById('errorMessage');

    // Fetch soil moisture data from API on button click
    fetchMoistureDataButton.addEventListener('click', async () => {
        // Reset previous state
        errorMessage.classList.add('hidden');
        moistureResults.classList.add('hidden');
        loadingSpinner.classList.remove('hidden');

        try {
            // Fetch data from the soil moisture API
            const response = await fetch('http://localhost:8001/soil-moisture/'); // Adjust API URL
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            console.log('Moisture Data:', data);

            // Display moisture data
            moistureLevel.textContent = `Moisture Level: ${data.moistureLevel}%`;
            moistureAdvice.textContent = getMoistureAdvice(data.moistureLevel);

            moistureResults.classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
            errorMessage.classList.remove('hidden');
        } finally {
            loadingSpinner.classList.add('hidden');
        }
    });

    // Function to provide advice based on moisture level
    function getMoistureAdvice(level) {
        if (level < 30) {
            return 'Soil is too dry. Water the plants immediately.';
        } else if (level >= 30 && level <= 60) {
            return 'Soil moisture is optimal.';
        } else {
            return 'Soil is too wet. Avoid overwatering.';
        }
    }
</script>
</body>
</html>
