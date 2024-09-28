from fastapi import FastAPI, Request
from fastapi.responses import JSONResponse
import json

app = FastAPI()

@app.post('/data')
async def receive_data(request: Request):
    data = await request.json()
    
    with open('IOT/response.json', 'w') as f:
        json.dump(data, f)
    
    moisture_level = data.get('moistureLevel', 0)
    ph_level = data.get('pHLevel', 0)
    
    recommendation = recommend_crop(moisture_level, ph_level)
    
    print(f"Recommended crop: {recommendation}") 
    
    return JSONResponse({
        "message": "Data received successfully", 
        "recommendation": recommendation,
        "moisture_level": moisture_level,
        "ph_level": ph_level
    })

@app.get('/recommendation')
async def get_recommendation():
    try:
        with open('IOT/response.json', 'r') as f:
            data = json.load(f)
        
        moisture_level = data.get('moistureLevel', 0)
        ph_level = data.get('pHLevel', 0)
        
        # Get crop recommendation
        recommendation = recommend_crop(moisture_level, ph_level)
        
        print(f"Recommended crop: {recommendation}")  # Print the recommendation
        
        return JSONResponse({
            "moisture_level": moisture_level,
            "ph_level": ph_level,
            "recommendation": recommendation
        })
    except FileNotFoundError:
        return JSONResponse({"error": "No data available. Please send data first."}, status_code=404)
    except json.JSONDecodeError:
        return JSONResponse({"error": "Invalid JSON data in file."}, status_code=500)

def recommend_crop(moisture, ph):
    if 30 <= moisture <= 40 and 5.5 <= ph <= 6.5:
        crop = "Paddy (Rice)"
    elif 20 <= moisture <= 30 and 6.0 <= ph <= 7.0:
        crop = "Wheat"
    elif 20 <= moisture <= 30 and 5.5 <= ph <= 7.0:
        crop = "Maize"
    else:
        crop = "No specific recommendation. Consider soil amendments or choosing a different crop."
    
    print(f"Recommended crop based on moisture {moisture} and pH {ph}: {crop}")
    return crop

# Remove the shutdown event as it's no longer needed without the serial connection
