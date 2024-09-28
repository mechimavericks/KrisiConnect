<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Krishi Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .user-message, .bot-message {
            max-width: 75%;
            word-wrap: break-word;
            padding: 12px 16px;
            margin: 8px 0;
            border-radius: 15px;
            font-size: 1rem;
            line-height: 1.5;
        }

        .user-message {
            background-color: #3b82f6;
            color: white;
            align-self: flex-end;
            border-radius: 15px 15px 0 15px;
        }

        .bot-message {
            background-color: #1a2749;
            color: white;
            align-self: flex-start;
            border-radius: 15px 15px 15px 0;
        }

        .chatbox {
            max-height: calc(100vh - 160px);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            margin-bottom: 120px;
            padding: 0 10px;
        }

        .chat-form-container {
            display: flex;
            justify-content: center;
            position: fixed;
            bottom: 80px;
            left: 0;
            right: 0;
            max-width: 600px;
            margin: 0 auto;
            background-color: #0d1727;
            padding: 10px 0;
        }

        .placeholder-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center;
            padding: 20px;
            color: #3b82f6;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: opacity 0.5s;
            opacity: 1;
        }

        .heading {
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        /* Spinner CSS */
        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Spinner container */
        .spinner-container {
            display: flex;
            justify-content: start;
            align-items: center;
            margin: 10px 0;
            height: 24px;
        }

        .prompt-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px; /* Reducing the space above the chat form */
        }

        .prompt-button {
            padding: 8px 12px;
            background-color: #3b82f62c;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .prompt-button:hover {
            background-color: #2563eb;
        }

        /* Enhancements for chat layout */
        .chat-wrapper {
            display: flex;
            justify-content: center;
            flex-direction: column;
            flex-grow: 1;
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 600px;
            margin: 0 auto;
            padding: 16px;
        }

        .chat-form {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 10px;
        }

        .input-container {
            flex-grow: 1;
            display: flex;
            gap: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            background-color: #1a2749;
            color: white;
            border: none;
            outline: none;
        }

        .send-btn {
            color: #3b82f6;
            font-size: 24px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .send-btn:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-[#0d1727] text-white font-sans flex flex-col min-h-screen">
<div class="max-w-sm p-5 flex-grow relative">
    <div class="chatbox p-4 md:p-6" id="chatbox">
        <div class="placeholder-message" id="placeholder">
            <h2 class="heading">कृषि सम्बन्धी कुनै पनि कुरा सोध्नुस्।</h2>
        </div>
    </div>

    <!-- Prompt Buttons Section -->
    <div class="prompt-buttons fixed bottom-40 z-10 left-2 grid grid-cols-2 sm:grid-cols-3">
        <button class="prompt-button" value='1' data-prompt="How to farm cucumber?"> How to farm cucumber?</button>
        <button class="prompt-button" value='2' data-prompt="How to farm corn?"> How to farm corn?</button>
        <button class="prompt-button" value='3' data-prompt="How to farm tomato?"> How to farm tomato?</button>
    </div>

    <!-- Chat Form Section -->
    <div class="chat-form-container max-w-sm">
        <form id="chatForm" class="flex items-center w-full pb-4">
            <a href="/scan" class='text-3xl p-2'><i class='bx bx-scan'></i></a>
            <div class="input-container">
                <input type="text" id="message" autocomplete="off" placeholder="Type your message..." required>
                <button type="submit" class="send-btn"><i class='bx bxs-send'></i></button>
            </div>
        </form>
    </div>

    @include('footer')
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.getElementById('chatForm');
    const chatbox = document.getElementById('chatbox');
    const placeholder = document.getElementById('placeholder');
    const promptButtons = document.querySelectorAll('.prompt-button'); // Select prompt buttons
    let spinner; // Define spinner element

    // Function to display messages
    function displayMessage(message, isUser = true) {
        const messageDiv = document.createElement('div');
        messageDiv.className = isUser ? 'user-message' : 'bot-message';
        messageDiv.innerHTML = message;
        chatbox.appendChild(messageDiv);
        chatbox.scrollTop = chatbox.scrollHeight;

        // Hide placeholder if there's at least one message
        if (chatbox.children.length > 1) {
            placeholder.style.opacity = '0'; // Fade out effect
            setTimeout(() => {
                placeholder.style.display = 'none';
            }, 500);
        }
    }

    // Function to display the preloader spinner
    function showSpinner() {
        spinner = document.createElement('div');
        spinner.className = 'spinner-container';
        spinner.innerHTML = '<div class="spinner"></div>';
        chatbox.appendChild(spinner);
        chatbox.scrollTop = chatbox.scrollHeight; // Scroll to the bottom
    }

    // Function to remove the preloader spinner
    function hideSpinner() {
        if (spinner) {
            chatbox.removeChild(spinner);
            spinner = null;
        }
    }

    // Function to send a message to the bot (API request)
    async function sendMessageToBot(message) {
        // Display user message in the chatbox
        displayMessage(message, true);

        // Show spinner while waiting for the bot's response
        showSpinner();

        // Make API request to FastAPI backend
        try {
            const response = await fetch('http://localhost:8001/chat/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ question: message }),
            });

            if (response.ok) {
                const data = await response.json();

                // Hide spinner before showing bot response
                hideSpinner();

                // Display bot's response in the chatbox
                displayMessage(data.response, false);
            } else {
                console.error('Error in fetching response:', response.statusText);
            }
        } catch (error) {
            hideSpinner(); // Ensure spinner is hidden on error
            console.error('Error:', error);
        }
    }

    // Handle static responses for prompt buttons
    async function handlePromptResponse(buttonValue) {
        let response;

        // Static responses based on button value
        switch (buttonValue) {
            case '1':
                response = 'Cucumber farming requires moderate temperatures, adequate water supply, and well-drained soil.';
                break;
            case '2':
                response = 'Corn farming is best done in warm climates with well-drained soil and requires regular irrigation.';
                break;
            case '3':
                response = 'Tomato farming thrives in warm weather and well-drained soil with adequate sunlight and water.';
                break;
            default:
                response = 'Invalid prompt selection.';
        }

        // Display the prompt as a user message
        displayMessage(`How to farm ${buttonValue === '1' ? 'cucumber' : buttonValue === '2' ? 'corn' : 'tomato'}?`, true);

        // Show spinner for 2 seconds before displaying the static response
        showSpinner();
        await new Promise(resolve => setTimeout(resolve, 2000)); // Wait for 2 seconds

        // Hide the spinner
        hideSpinner();

        // Display the static response in chat format
        displayMessage(response, false);
    }

    // Form submission (manual message)
    chatForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const messageInput = document.getElementById('message');
        const message = messageInput.value;

        // Clear input
        messageInput.value = '';

        // Send the user's message to the bot (dynamic response)
        sendMessageToBot(message);
    });

    // Event listeners for the prompt buttons (static responses)
    promptButtons.forEach(button => {
        button.addEventListener('click', () => {
            const buttonValue = button.value; // Get the button value
            handlePromptResponse(buttonValue);
            promptButtons.forEach(btn => btn.style.display = 'none');
            // Send static response based on value
        });

    });
});

</script>
</body>
</html>
