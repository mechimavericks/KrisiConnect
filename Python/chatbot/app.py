from flask import Flask, render_template_string, request
from langchain.prompts import ChatPromptTemplate
from langchain_google_genai import ChatGoogleGenerativeAI
import os
from dotenv import load_dotenv

# Load the environment variables
load_dotenv()

app = Flask(__name__)

api_key = os.getenv("GOOGLE_API_KEY")

# HTML template
html_template = """
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .chat-container {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
        .user-message {
            background-color: #e6f2ff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .bot-message {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        form {
            display: flex;
        }
        input[type="text"] {
            flex-grow: 1;
            padding: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Agriculture Chatbot</h1>
    <div class="chat-container">
        {% if query %}
            <div class="user-message">
                <strong>You:</strong> {{ query }}
            </div>
        {% endif %}
        {% if response %}
            <div class="bot-message">
                <strong>Bot:</strong> {{ response }}
            </div>
        {% endif %}
    </div>
    <form action="/" method="post">
        <input type="text" name="query" placeholder="Ask a question about agriculture..." required>
        <input type="submit" value="Send">
    </form>
</body>
</html>
"""

def is_greeting(query):
    greetings = ["hello", "hi", "hey", "namaste", "नमस्ते", "हेलो", "हाइ"]
    return any(greeting in query.lower() for greeting in greetings)

def get_agriculture_response(query):
    chat_prompt = ChatPromptTemplate.from_template(
        '''You are an AI assistant specialized in agriculture and plant-related topics. 
        Provide a helpful response to the following query: {query}
        If the query is not related to agriculture or plants, politely explain that you can only answer questions about agriculture and plants.
        IMPORTANT: Respond ONLY in Nepali language. Do not use any English.'''
    )
    
    llm = ChatGoogleGenerativeAI(temperature=0.7, model="gemini-pro", google_api_key=api_key)
    chain = chat_prompt | llm
    response = chain.invoke({"query": query})
    return response.content

@app.route("/", methods=["GET", "POST"])
def chat():
    query = None
    response = None
    
    if request.method == "POST":
        query = request.form.get("query")
        response = get_agriculture_response(query)
    
    return render_template_string(html_template, query=query, response=response)

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
