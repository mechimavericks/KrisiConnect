from flask import Flask, render_template_string, request
from langchain.prompts import PromptTemplate
from langchain.chains import LLMChain
from langchain_google_genai import GoogleGenerativeAI
import os

app = Flask(__name__)

api_key = os.getenv("GOOGLE_API_KEY")


def is_agriculture_related(query):
    agriculture_keywords = [
        "plant", "crop", "farm", "agriculture", "soil", "harvest", "seed", "fertilizer", "pest", "disease",
        "irrigation", "livestock", "horticulture", "organic", "greenhouse", "compost", "pruning", "grafting",
        "plowing", "tilling", "sowing", "weeding", "mulching", "pollination", "germination", "hydroponics",
        "agroforestry", "permaculture", "aquaculture", "silviculture", "apiculture", "viticulture",
        "agronomy", "animal husbandry", "poultry", "dairy", "fodder", "pasture", "rotation", "sustainable",
        "biotechnology", "genetic", "hybrid", "yield", "drought", "flood", "climate", "weather",
        "pesticide", "herbicide", "fungicide", "insecticide", "organic", "inorganic", "manure",
        "tractor", "plow", "cultivator", "sprayer", "harvester", "silo", "greenhouse",
        "market", "price", "subsidy", "policy", "rural", "cooperative", "extension",
        "कृषि", "खेती", "बाली", "मल", "बीउ", "माटो", "सिंचाई", "कीट", "रोग", "फसल",
        "पशुपालन", "बागवानी", "जैविक", "कम्पोस्ट", "काँटछाँट", "कलमी", "जोताई", "रोपाई",
        "गोडमेल", "परागसेचन", "अंकुरण", "जलकृषि", "मौरीपालन", "अन्नबाली", "फलफूल", "तरकारी"
    ]
    return any(keyword in query.lower() for keyword in agriculture_keywords)

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

@app.route("/", methods=["GET", "POST"])
def chat():
    query = None
    response = None
    
    if request.method == "POST":
        query = request.form.get("query")
        if not is_agriculture_related(query):
            response = "माफ गर्नुहोस्, म केवल कृषि र बोट-बिरुवा सम्बन्धी प्रश्नहरूको उत्तर दिन सक्छु।"
        else:
            chat_template = PromptTemplate(
                input_variables=['query'],
                template='''You are an AI assistant specialized in agriculture and plant-related topics. 
                Provide a helpful response to the following query: {query}
                IMPORTANT: Respond ONLY in Nepali language. Do not use any English.'''
            )
            
            llm = GoogleGenerativeAI(temperature=0.7, model="gemini-pro", api_key=api_key)
            chat_chain = LLMChain(llm=llm, prompt=chat_template, verbose=True)
            response = chat_chain.run(query=query)
    
    return render_template_string(html_template, query=query, response=response)

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
