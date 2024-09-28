from fastapi import FastAPI
import serial
import time

app = FastAPI()

# Adjust the port and baudrate as needed
SERIAL_PORT = '/dev/ttyUSB0'  # Change this to your Arduino's COM port
BAUD_RATE = 9600
arduino = serial.Serial(SERIAL_PORT, BAUD_RATE)
time.sleep(2)  # Wait for the serial connection to initialize

@app.get("/sensordata")
async def get_sensor_data():
    # Read sensor data from Arduino
    if arduino.in_waiting > 0:
        line = arduino.readline().decode('utf-8').rstrip()  # Read the line from Arduino
        return {"sensor_data": line}
    else:
        return {"error": "No data available"}

@app.on_event("shutdown")
def shutdown_event():
    arduino.close()  # Close the serial connection on shutdown
