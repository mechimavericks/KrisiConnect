# Importing the Necessary Libraries
from fastapi import FastAPI
from pydantic import BaseModel
from langchain.prompts import ChatPromptTemplate
from langchain_google_genai import ChatGoogleGenerativeAI
import os,markdown
from dotenv import load_dotenv

# Load the environment variables
load_dotenv() 

# API key for the Google API
apikey = os.getenv("API_KEY")
print(apikey)

# Create a FastAPI instance
app = FastAPI()


# Define the request model
class ChatRequest(BaseModel):
    question: str


def is_greeting(query):
    greetings = ["hello", "hi", "hey", "namaste", "नमस्ते", "हेलो", "हाइ"]
    return any(greeting in query.lower() for greeting in greetings)

def get_agriculture_response(query):
    agriculture_keywords = ["farm", "farming", "agriculture", "crop", "plant", "soil", "harvest", "कृषि", "खेती", "बाली"]
    
    if any(keyword in query.lower() for keyword in agriculture_keywords):
        chat_prompt = ChatPromptTemplate.from_template(
            '''You are an AI assistant specialized in agriculture and farming topics. 
            Provide a detailed and informative response to the following query about agriculture: {query}
            
            IMPORTANT: 
            - Respond ONLY in Nepali language.
            - Provide specific information related to the query.
            - If the query is general, give an overview of the topic.
            - Ensure your response is natural, conversational, and informative.'''
        )
    else:
        chat_prompt = ChatPromptTemplate.from_template(
            '''You are an AI assistant specialized in agriculture and plant-related topics. 
            Analyze the following user input: {query}

            If the input is a greeting:
            Respond with a friendly greeting in Nepali and encourage the user to ask an agriculture-related question.

            If the input is not related to agriculture or plants:
            Politely explain in Nepali that you can only answer questions about agriculture and plants, 
            and encourage the user to ask an agriculture-related question.

            IMPORTANT: 
            - Always respond ONLY in Nepali language.
            - Ensure your response is natural and conversational.'''
        )
    
    llm = ChatGoogleGenerativeAI(temperature=0.7, model="gemini-pro", google_api_key=apikey)
    chain = chat_prompt | llm
    response = chain.invoke({"query": query})
    return response.content

# POST request for the chat API
@app.post("/chat/")
async def chat(request: ChatRequest):
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
        response = get_agriculture_response(question)

        # Convert the response to markdown
        responsetext=markdown.markdown(response)
        
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
