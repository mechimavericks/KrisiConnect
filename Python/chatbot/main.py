# Importing the Necessary Libraries
from fastapi import FastAPI
from pydantic import BaseModel
import google.generativeai as gemini
import random,os,markdown
from dotenv import load_dotenv

# Load the environment variables
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
        question = (request.question).strip()
        if not question:
            # Prepare the error response data
            data = {
                "status": 400 , 
                "error": "Bad Request! Please provide a valid question!"
            }
            return {"response": data}

        # Defining the template for the AI model
        template = (
            f"You are an AI assistant specialized in agriculture. "
            f"Provide a detailed response only if the following question is related to agriculture, farming, crops, livestock, or other agricultural topics. "
            f"Ignore the question if it is not related to these topics. "
            f"Question: {question} Answer: ''"
        )


        # Generate the response from the AI model
        response = model.generate_content(template)

        # Convert the response to markdown
        responsetext=markdown.markdown(response.text)
        
        # Prepare the response data
        data = {
            "status": 200 ,
            "question": question,
            "response": responsetext
        }

    except Exception as e:
        print(f"An unexpected error occurred: {e}")
        # Prepare the error response data
        data = {
            "status": 500 , 
            "error": "Sorry! Something went wrong!"
        }
    
    # Return the response data
    return {"response": data}
