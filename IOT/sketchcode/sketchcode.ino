// Define pin numbers
const int moistureSensorPin = A0; // Moisture sensor connected to A0
const int phSensorPin = A1;       // pH sensor connected to A1

void setup() {
    Serial.begin(9600); // Initialize Serial communication at 9600 bps
}

void loop() {
    // Read sensor values
    int moistureValue = analogRead(moistureSensorPin);
    int phValue = analogRead(phSensorPin);

    // Convert moisture reading (0-1023) to percentage (0-100)
    float moisturePercentage = map(moistureValue, 0, 1023, 0, 100);

    // Convert pH sensor value (0-1023) to a pH scale (0-14)
    float voltage = phValue * (5.0 / 1023.0); // Convert to voltage (0-5V)
    float phLevel = map(voltage, 0.0, 5.0, 0.0, 14.0); // Map voltage to pH scale (0-14)
    
    // Send formatted data to Serial Monitor in JSON structure
    Serial.print(F("{\"moistureLevel\": "));
    Serial.print(moisturePercentage, 2);  // Print with 2 decimal precision
    Serial.print(F(", \"phLevel\": "));
    Serial.print(phLevel, 2);              // Print with 2 decimal precision
    Serial.println(F("}"));

    delay(2000); // Delay 2 seconds before next reading
}
