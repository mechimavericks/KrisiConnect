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
        .user-message {
            background-color: #1a2749;
            align-self: flex-end;
            margin: 5px 0;
            border-radius: 15px 15px 0 15px;
            padding: 10px;
            max-width: 75%;
            word-wrap: break-word;
        }

        .bot-message {
            background-color: #ffffff33;
            align-self: flex-start;
            margin: 5px 0;
            border-radius: 15px 15px 15px 0;
            padding: 10px;
            max-width: 75%;
            word-wrap: break-word;
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
        }

        .placeholder-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center;
            padding: 20px;
            color: #3b82f6; /* Match theme color */
            background: rgba(255, 255, 255, 0.1); /* Light background for contrast */
            border-radius: 12px; /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Shadow for depth */
            transition: opacity 0.5s;
            opacity: 1;
        }

        .heading {
            font-size: 1.5rem;
            font-weight: 700; /* Bold font */
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5); /* Subtle shadow for depth */
        }
    </style>
</head>
<body class="bg-[#0d1727] text-white font-sans flex flex-col min-h-screen">
<div class="max-w-sm mx-auto p-5 flex-grow">
    <div class="chatbox p-4 md:p-6" id="chatbox">
        <div class="placeholder-message" id="placeholder">
            <h2 class="heading">कृषि सम्बन्धी कुनै पनि कुरा सोध्नुस्।</h2>
        </div>
    </div>

    <div class="chat-form-container max-w-sm">
        <form id="chatForm" class="flex items-center w-full pb-4">
            <a href="/scan" class='text-3xl p-2'><i class='bx bx-scan'></i></a>
            <input type="text" id="message" autocomplete="off" class="flex-1 p-3 rounded-lg bg-[#1a2749] text-white border-none outline-none" placeholder="Type your message..." required>
            <button type="submit" class="md:ml-2 text-[#3b82f6] text-2xl hover:bg-[#2563eb] text-white p-2 rounded-lg"><i class='bx bxs-send'></i></button>
        </form>
    </div>
    
    @include('footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatForm = document.getElementById('chatForm');
        const chatbox = document.getElementById('chatbox');
        const placeholder = document.getElementById('placeholder');

        // Function to display messages
        function displayMessage(message, isUser = true) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser ? 'user-message' : 'bot-message';
            messageDiv.textContent = message;
            chatbox.appendChild(messageDiv);
            chatbox.scrollTop = chatbox.scrollHeight; // Scroll to the bottom

            // Hide placeholder if there's at least one message
            if (chatbox.children.length > 1) {
                placeholder.style.opacity = '0'; // Fade out effect
                setTimeout(() => {
                    placeholder.style.display = 'none'; // Remove from DOM after fade out
                }, 500); // Match timeout with opacity transition duration
            }
        }

        
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chatForm');
    const chatbox = document.getElementById('chatbox');

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const messageInput = document.getElementById('message');
        const message = messageInput.value;

        // Clear input
        messageInput.value = '';

        // Display user message in the chatbox
        chatbox.innerHTML += `
            <div class="user-message">${message}</div>
        `;

        // Make API request to FastAPI backend
        try {
            const response = await fetch('http://127.0.0.1:8001/chat/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ question: message }),
            });

            if (response.ok) {
                const data = await response.json();
                const botResponse = data.result.response;

                // Append bot's response with a "Speak" button to the chatbox
                chatbox.innerHTML += `
                    <div class="bot-message-container">
                        <div class="bot-message">${botResponse}</div>
                        <button class="speak-btn">🔊</button>
                    </div>
                `;

                // Re-attach event listeners to the new "Speak" buttons
                attachSpeakButtonListeners();
            } else {
                console.error('Error in fetching response:', response.statusText);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    function attachSpeakButtonListeners() {
        const speakButtons = document.querySelectorAll('.speak-btn');
        speakButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Find the nearest .bot-message element within the same container
                const messageContainer = this.closest('.bot-message-container');
                const messageElement = messageContainer.querySelector('.bot-message');

                if (messageElement) {
                    const message = messageElement.textContent.trim();
                    speakText(message);
                } else {
                    console.error('Error: .bot-message element not found');
                }
            });
        });
    }

    function speakText(text) {
        // alert(text);
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'hi-IN'; // You can set this to any supported language code
        speechSynthesis.speak(utterance);
    }
});
</script>
</body>
</html>
