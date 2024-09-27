<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Plant - Krishi Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('ICON.PNG') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
</head>
<body class="bg-[#0d1727] text-white font-sans flex items-center justify-center min-h-screen">
<div class="max-w-sm mx-auto p-5">
    <header class="mb-6 text-center">
        <h1 class="text-2xl font-bold mb-4">बिरुवा स्क्यान गर्नुहोस्</h1>
    </header>

    <div class="flex flex-col items-center justify-center mb-6">
        <video id="video" class="rounded-lg shadow-lg mb-4 w-full" autoplay></video>
        <canvas id="canvas" class="hidden"></canvas>
        <img id="capturedImage" class="w-full h-auto rounded-lg border-amber-50 border-4 shadow-lg hidden mb-6" alt="Scanned Plant">
    </div>

    <div class="text-center">
        <button id="captureButton" class="mt-4 px-4 py-2 bg-blue-500 rounded-lg"> स्क्यान गर्नुहोस्</button>
        <div id="options" class="flex justify-center space-x-4 hidden mt-4">
            <button id="rescanButton" class="px-6 py-3 bg-red-600 rounded-full">फेरि स्क्यान गर्नुहोस्</button>
            <button id="viewResultButton" class="px-6 py-3 bg-green-600 rounded-full">नतिजा हेर्नुहोस्</button>
        </div>

        <div id="results" class="mt-4 text-left bg-gray-800 p-4 rounded-lg shadow-lg hidden overflow-auto" >
            <h3 class="text-lg font-semibold mb-2">Disease Summary</h3>
            <pre id="diseaseSummary"></pre>
        </div>

        <div id="loadingSpinner" class="hidden mt-4">
            <i class="bx bx-loader-alt animate-spin text-4xl"></i>
            <p>Processing...</p>
        </div>

        <div id="errorMessage" class="hidden mt-4 text-red-500">
            <p>Failed to process the image. Please try again.</p>
        </div>
    </div>

    @include('footer')
</div>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('captureButton');
    const rescanButton = document.getElementById('rescanButton');
    const viewResultButton = document.getElementById('viewResultButton');
    const capturedImage = document.getElementById('capturedImage');
    const options = document.getElementById('options');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const errorMessage = document.getElementById('errorMessage');
    const diseaseSummary = document.getElementById('diseaseSummary');

    // Access the camera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
            video.play();
        })
        .catch((err) => {
            console.error("Error accessing camera: " + err);
            alert('Unable to access camera. Please allow camera access.');
        });

    // Capture image from the video stream
    captureButton.addEventListener('click', () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Stop video stream after capture
        video.pause();
        video.srcObject.getTracks().forEach(track => track.stop());

        // Convert the canvas to a data URL
        const dataURL = canvas.toDataURL('image/png');
        capturedImage.src = dataURL;
        capturedImage.classList.remove('hidden');

        video.classList.add('hidden');
        captureButton.classList.add('hidden');
        options.classList.remove('hidden');
    });

    // Rescan (reset the UI)
    rescanButton.addEventListener('click', () => {
        options.classList.add('hidden');
        capturedImage.classList.add('hidden');
        captureButton.classList.remove('hidden');
        diseaseSummary.innerText = '';
        document.getElementById('results').classList.add('hidden');
        errorMessage.classList.add('hidden');

        // Restart the camera stream
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
                video.play();
                video.classList.remove('hidden');
            })
            .catch((err) => {
                console.error("Error accessing camera: " + err);
            });
    });

    // View result by sending the captured image to the server
    viewResultButton.addEventListener('click', async () => {
        loadingSpinner.classList.remove('hidden');
        errorMessage.classList.add('hidden');
        document.getElementById('results').classList.add('hidden');

        canvas.toBlob(async (blob) => {
            const formData = new FormData();
            formData.append('file', blob, 'plant_image.png');

            try {
                const response = await fetch('http://localhost:8001/predict/', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                console.log('Response Data:', data);

                // Check if the predictions array has data
                if (data && data.length > 0) {
                    const prediction = data[0]; // Get the first prediction
                    const confidence = (prediction.confidence * 100).toFixed(2); // Convert to percentage

                    // Display the disease class and confidence level
                    diseaseSummary.innerHTML = `<div class='relative w-11/12'>

                        <h3 class="text-lg font-semibold mb-2">${prediction.class} (Confidence: ${confidence}%)</h3>
                        <div>${prediction.summary}</div>

                        </div>
                    `;

                    document.getElementById('results').classList.remove('hidden');
                } else {
                    // Handle the case where there are no predictions
                    diseaseSummary.innerHTML = '<p>No disease detected or image not recognized.</p>';
                    document.getElementById('results').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.classList.remove('hidden');
            } finally {
                loadingSpinner.classList.add('hidden');
            }
        }, 'image/png');
    });
</script>
</body>
</html>
