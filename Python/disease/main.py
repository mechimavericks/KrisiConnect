from fastapi import FastAPI, File, UploadFile
from fastapi.responses import JSONResponse
from ultralytics import YOLO
from langchain.prompts import PromptTemplate
from langchain.chains import LLMChain
from langchain_google_genai import GoogleGenerativeAI
import os

app = FastAPI()

model = YOLO("last.pt")

api_key = os.getenv("GOOGLE_API_KEY")

UPLOAD_FOLDER = 'static/uploads'
if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)

def generate_summary(disease):
    summary_template = PromptTemplate(
        input_variables=['disease'],
        template='''Generate a summary of cures and precautions for the plant disease: {disease}. 
        Include treatment methods and preventive measures. 
        IMPORTANT: Respond ONLY in Nepali language. Do not use any English.
        
        Your response should follow this structure in Nepali:
        1. रोगको नाम (Disease Name)
        2. रोगको कारण (Cause of the Disease)
        3. रोगको लक्षणहरू (Symptoms of the Disease)
        4. उपचार विधिहरू (Treatment Methods)
        5. रोकथामका उपायहरू (Preventive Measures)
        6. थप सुझावहरू (Additional Recommendations)
        '''
    )
    llm = GoogleGenerativeAI(temperature=0.7, model="gemini-pro", api_key=api_key)
    summary_chain = LLMChain(llm=llm, prompt=summary_template, verbose=True)
    summary = summary_chain.run(disease=disease)
    return summary

@app.post("/predict")
async def predict_disease(file: UploadFile = File(...)):
    if file:
        filepath = os.path.join(UPLOAD_FOLDER, file.filename)
        with open(filepath, "wb") as f:
            f.write(await file.read())
        
        results = model(source=filepath, save=True)
        
        predictions = results[0].boxes.data.tolist()
        class_names = results[0].names
        
        formatted_predictions = []
        for pred in predictions:
            class_id = int(pred[5])
            confidence = pred[4]
            disease = class_names[class_id]
            summary = generate_summary(disease)
            formatted_predictions.append({
                'class': disease,
                'summary': summary,
                'confidence': confidence
            })
        
        return JSONResponse(content={"predictions": formatted_predictions})

    return JSONResponse(content={"error": "No file uploaded"}, status_code=400)

# Run the app with: `uvicorn your_script_name:app --reload`
