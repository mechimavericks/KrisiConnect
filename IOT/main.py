from fastapi import FastAPI
from fastapi.responses import JSONResponse
from fastapi.middleware.cors import CORSMiddleware
import serial
import json

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

SERIAL_PORT = '/dev/ttyUSB1'  # Change this to your Arduino's COM port
BAUD_RATE = 9600
arduino = serial.Serial(SERIAL_PORT, BAUD_RATE)

@app.get("/sensordata")
async def getsensordata():
    try:
        if arduino.in_waiting > 0:
            line = arduino.readline().decode('utf-8').rstrip()
            sensordata = json.loads(line)

            # Extract moisture and pH values
            moisture = sensordata['moistureLevel']
            ph = sensordata['phLevel']

            # Crop recommendation logic
            crop = "No Specific Recommendation. Consider Soil Amendments."

            # Crop recommendation based on moisture and pH ranges
            if 30 <= moisture <= 60 and 5.5 <= ph <= 6.5:
                crop = "Paddy (Rice)"
            elif 20 <= moisture <= 35 and 6.0 <= ph <= 7.0:
                crop = "Wheat"
            elif 20 <= moisture <= 35 and 5.5 <= ph <= 7.0:
                crop = "Maize"
            elif 35 <= moisture <= 55 and 6.0 <= ph <= 7.5:
                crop = "Barley"
            elif 40 <= moisture <= 70 and 6.0 <= ph <= 7.5:
                crop = "Sugarcane"
            elif 20 <= moisture <= 50 and 6.0 <= ph <= 7.5:
                crop = "Potato"
            elif 10 <= moisture <= 30 and 5.5 <= ph <= 7.0:
                crop = "Cotton"
            elif 25 <= moisture <= 50 and 5.0 <= ph <= 6.5:
                crop = "Tomato"
            elif 20 <= moisture <= 60 and 5.5 <= ph <= 6.5:
                crop = "Soybean"
            elif 15 <= moisture <= 45 and 6.0 <= ph <= 7.5:
                crop = "Peanut"
            elif 30 <= moisture <= 60 and 5.5 <= ph <= 6.5:
                crop = "Banana"
            else:
                crop = "No suitable crop found. Consider consulting an agronomist."


            # Create a response
            response_content = {
                "sensorData": {
                    "moistureLevel": moisture,
                    "phLevel": ph
                },
                "recommendedCrop": crop
            }
            return JSONResponse(status_code=200, content=response_content)

        else:
            return JSONResponse(
                status_code=204,
                content={
                    "message": "No sensor data available"
                }
            )
    except Exception as e:
        return JSONResponse(
            status_code=500,
            content={
                "error": f"Internal Server Error: {str(e)}"
            }
        )
