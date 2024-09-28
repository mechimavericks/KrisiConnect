from fastapi import FastAPI
from fastapi.responses import JSONResponse
from fastapi.middleware.cors import CORSMiddleware
# import serial,json

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# SERIAL_PORT = '/dev/ttyUSB0'  # Change this to your Arduino's COM port
# BAUD_RATE = 9600
# arduino = serial.Serial(SERIAL_PORT, BAUD_RATE)

@app.get("/sensordata")
async def getsensordata():
    return JSONResponse(
        status_code=200,
        content={
            "moistureLevel": 33.00, 
            "phLevel": 6.21,
            "crops" : "Tomato"
        }
    )

    # try:
    #     if arduino.in_waiting > 0:
    #         line = arduino.readline().decode('utf-8').rstrip()  

    #         return JSONResponse(
    #             status_code=200,
    #             content=line
    #         )
    #     else:
    #         return JSONResponse(
    #             status_code=204,
    #             content={
    #                 "message": "No sensor data available"
    #             }
    #         )
    # except Exception as e:
    #     return JSONResponse(
    #         status_code=500,
    #         content={
    #             "error": f"Internal Server Error: {str(e)}"
    #         }
    #     )
