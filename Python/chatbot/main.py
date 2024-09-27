# Creating the Chatbot API for the Response the Every Request

import fastapi



app = fastapi.FastAPI()
apikey= ""


@app.get("/")
def index():
    return {"key": "value"}