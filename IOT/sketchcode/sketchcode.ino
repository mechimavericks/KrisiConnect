// Define pin numbers
const int moistureSensorPin = A0; // Moisture sensor connected to A0
const int phSensorPin = A1;        // pH sensor connected to A1

void setup() {
    Serial.begin(9600); // Initialize Serial communication at 9600 bps
}

void loop() {
    // Read the moisture level from the moisture sensor
    int moistureValue = analogRead(moistureSensorPin);
    // Read the pH level from the pH sensor
    int phValue = analogRead(phSensorPin);

    // Convert the moisture reading to a percentage (0-100)
    float moisturePercentage = map(moistureValue, 0, 1023, 0, 100);
    
    // Convert the pH reading to a scale of 0-14
    // Assuming the pH sensor outputs a range corresponding to the pH scale (0-14)
    float phLevel = (phValue / 1023.0) * 14.0;

    // Print formatted data in JSON-like structure to Serial Monitor
    Serial.print("{\"moistureLevel\": ");
    Serial.print(moisturePercentage);
    Serial.print(", \"pHLevel\": ");
    Serial.print(phLevel);
    Serial.println("}");

    // Delay before the next reading
    delay(2000); // Wait for 2 seconds before taking the next reading
}
