from fastapi import FastAPI
from fastapi.responses import JSONResponse
import serial
import json
import phvalue as ph

app = FastAPI()

SERIAL_PORT = '/dev/ttyUSB0'  # Change this to your Arduino's COM port
BAUD_RATE = 9600
arduino = serial.Serial(SERIAL_PORT, BAUD_RATE)

@app.get("/sensordata")
async def getsensordata():
    try:
        if arduino.in_waiting > 0:
            line = arduino.readline().decode('utf-8').rstrip()  
            jsondata = json.loads(line) 
            moisture_level = jsondata.get('moisture')  

            if moisture_level is not None:
                ph_value = ph.getThePhValue(moisture_level)
                return JSONResponse(
                    status_code=200,
                    content={
                        "moisture": moisture_level,
                        "ph": ph_value
                    }
                )
            else:
                return JSONResponse(
                    status_code=204,
                    content={
                        "error": "No sensor data available"
                    }
                )
        else:
            return JSONResponse(
                status_code=204,
                content={
                    "status": 204,
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
