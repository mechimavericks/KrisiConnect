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
<div class="max-w-sm w-full mx-auto p-5">
    <header class="mb-6 text-center">
        <h1 class="text-2xl font-bold mb-4">माटोको आर्द्रता मापन गर्नुहोस्</h1>
    </header>

    <div class="text-center">
        <!-- Button to fetch moisture data -->
        <button id="fetchMoistureData" class="mt-4 px-4 py-2 bg-blue-500 rounded-lg text-white font-semibold">
            आर्द्रता मापन गर्नुहोस्
        </button>

        <!-- Loading spinner for processing state -->
        <div id="loadingSpinner" class="hidden mt-4 flex items-center justify-center">
            <i class="bx bx-loader-alt animate-spin text-4xl"></i>
            <p class="ml-2">Processing...</p>
        </div>

        <!-- Result container for displaying readable API response -->
        <div id="moistureResults" class="mt-4 text-left bg-gray-800 p-4 rounded-lg shadow-lg hidden">
            <h3 class="text-lg font-semibold mb-2">मापन परिणामहरू</h3>
            <div class="flex items-center mb-2">
                <span class="font-semibold">माटोको आर्द्रता स्तर:</span>
                <p id="moistureLevel" class="ml-2"></p>
            </div>
            <div class="flex items-center mb-2">
                <span class="font-semibold">pH स्तर:</span>
                <p id="phLevel" class="ml-2"></p>
            </div>
            <div class="flex items-center mb-2">
                <span class="font-semibold">बाली:</span>
                <p id="crops" class="ml-2"></p>
            </div>
            <div id="moistureAdvice" class="mt-4 p-2 bg-gray-900 rounded-md"></div>
        </div>

        <!-- Error message for failure cases -->
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
    const phLevel = document.getElementById('phLevel');
    const crops = document.getElementById('crops');
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
            const response = await fetch('http://localhost:8002/sensordata/'); // Adjust API URL
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            console.log('Moisture Data:', data);

            // Display the readable API response
            moistureLevel.textContent = `${data.moistureLevel}%`;
            phLevel.textContent = `${data.phLevel}`;
            crops.textContent = data.crops;

            // Provide advice based on moisture level
            moistureAdvice.innerHTML = getMoistureAdvice(data.moistureLevel);

            moistureResults.classList.remove('hidden');
        } catch (error) {
            errorMessage.classList.remove('hidden');
        } finally {
            loadingSpinner.classList.add('hidden');
        }
    });

    // Function to provide advice based on moisture level
    function getMoistureAdvice(level) {
        if (level < 30) {
            return `<p class="text-red-500">माटो धेरै सुक्खा छ। तत्काल सिंचाइ गर्नुहोस्।</p>`;
        } else if (level >= 30 && level <= 60) {
            return `<p class="text-green-500">माटोको आर्द्रता स्तर उपयुक्त छ।</p>`;
        } else {
            return `<p class="text-yellow-500">माटो धेरै भिजेको छ। थप पानी दिनु हुँदैन।</p>`;
        }
    }
</script>
</body>
</html>
