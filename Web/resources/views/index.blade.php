<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krishi Connect - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body class="bg-[#0d1727] text-white font-sans">
<div class="max-w-sm mx-auto p-5">
    <!-- Header -->
    
    <header class="flex justify-between items-center mb-6">
        <div>
            <div class="text-lg">शुभ प्रभात,</div>
            <div class="text-4xl font-bold mt-2 w-64">Sanket Shiwakoti</div>
        </div>
        <div class="w-12 h-12 rounded-full overflow-hidden">
            <p alt="Profile Picture" class="w-full h-full object-cover text-center pt-3 font-extrabold text-xl bg-blue-600 self-start">S</p>
        </div>
    </header>

    <!-- Weather Information -->
    <section class="bg-[#19233d]  rounded-lg  mb-6">
        <p class="p-2">आजको तापक्रम विभरण</p>

        <div class="p-4 flex justify-between items-center">
        <div class="text-3xl font-bold flex">28°
        <img src="/image4.png"></div>

        <div class="  h-16 bg-white mx-1" style="border:1px solid white;width:1px"></div>

        <div class="text-left text-justify">
            <p>वर्षा सम्भावना (Rain): 65%</p>
            <p>हावा चल्छ (Wind): 12KM/H</p>
            <p>नमी (Humidity): 77%</p>
        </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="mb-6">
        <h2 class="text-xl mb-4">कृषि समाचार</h2>
        <div class="bg-[#19233d] p-3 rounded-lg flex flex-row-reverse justify-around items-center mb-3">
            <img src="/budget.png" alt="News Image 1" class="w-16 h-12 rounded-lg mr-3 object-cover">
            <p>कसरी हामिले यो सरकारी योजना...</p>
        </div>
        <div class="bg-[#19233d] p-3 rounded-lg flex flex-row-reverse justify-around items-center mb-3">
            <img src="/news2.png" alt="News Image 2" class="w-16 h-12 rounded-lg mr-3 object-cover">
            <p>सरकारले बढायो कृषि अनुदान बजेट</p>
        </div>
        <div class="bg-[#19233d] p-3 rounded-lg flex flex-row-reverse justify-around items-center">
            <img src="/news3.png" alt="News Image 3" class="w-16 h-12 rounded-lg mr-3 object-cover">
            <p>आफु, परिवार र समाजमा माटो पुज्न...</p>
        </div>
    </section>

    <!-- Video Section -->
    <section class="mb-6">
        <h2 class="text-xl mb-4">रोचक भिडियोहरु</h2>
        <iframe class="w-full" src="https://www.youtube.com/embed/ZpDJycIVrbo?si=MOcrN7grsHbpFMv3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>    </section>
   <!-- <iframe class="w-full" src="https://www.youtube.com/embed/weHOhgNybGQ?si=JwD1Myq0QcmBNCrK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe> -->
    <!-- Footer -->
@include('footer')
</div>

<script src="”http://localhost:8000/sw.js”">

</script>

<script>

    if (!navigator.serviceWorker.controller) {

        navigator.serviceWorker.register('/sw.js').

        then(function (reg) {

            console.log('Service worker has been registered for scope: ' + reg.scope);

        });

    }

</script>




</body>
</html>
