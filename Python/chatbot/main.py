from fastapi import FastAPI
from pydantic import BaseModel
import google.generativeai as gemini
import random,os,markdown
from dotenv import load_dotenv

load_dotenv() 

# API key for the Google API
apikey = os.getenv("API_KEY")
print(apikey)

# Create a FastAPI instance
app = FastAPI()

# Configure the Gemini API
gemini.configure(api_key=apikey)
model = gemini.GenerativeModel("gemini-1.5-flash")

# Define the request model
class ChatRequest(BaseModel):
    question: str

# POST request for the chat API
@app.post("/chat/")
async def chat_api(request: ChatRequest):
    try:
        question = request.question
        # Defining the template for the AI model
        template=f"You are an AI assistant specialized in agriculture. ONLY answer the following question if it is related to agriculture, farming, crops, livestock, or other agricultural topics. If the question is not related to agriculture, respond with 'Sorry'. Question: {question} Answer:'' "

        response = model.generate_content(template)

        sorryresponse=["I can only answer questions related to agriculture.","Sorry, I am only able to answer questions related to agriculture.","I can only answer questions related to agriculture, farming, crops, livestock, or other agricultural topics.","Sorry, I am only trained to answer questions related to agriculture related Questions."]

        if response.text=="Sorry. \n":
            responsetext=sorryresponse[random.randint(0,3)]
        else:
            responsetext=markdown.markdown(response.text)
        data = {
            "status": 200 ,
            "question": question,
            "response": responsetext
        }

    except Exception as e:
        print(f"An unexpected error occurred: {e}")
        data = {
            "status": 500 , 
            "error": "Sorry! Something went wrong!"
        }
    
    return {"response": data}
