// Define pin numbers
const int moistureSensorPin = A0; // Moisture sensor connected to A0
const int phSensorPin = A1;       // pH sensor connected to A1

void setup() {
    Serial.begin(9600); // Initialize Serial communication at 9600 bps
}

void loop() {
    // Read sensor values
    int moistureValue = analogRead(moistureSensorPin);
    // int phValue = analogRead(phSensorPin); // Unused, can be removed

    // Convert moisture reading (0-1023) to percentage (0-100)
    float moisturePercentage = map(moistureValue, 0, 1023, 0, 100);

    // Initialize phLevel variable
    float phLevel;

    // Determine pH level based on moisture percentage
    if (moisturePercentage >= 98.9) {
        phLevel = 7; // If moisture is high, set pH to 7
    } else if (moisturePercentage < 0) {
        phLevel = 14; // Set pH to 14 for extreme low moisture (this case may not occur)
    } else {
        phLevel = 14 - (14 * moisturePercentage / 98.9); // Calculate pH based on moisture
    }

    // Send formatted data to Serial Monitor in JSON structure
    Serial.print(F("{\"moistureLevel\": "));
    Serial.print(moisturePercentage, 2);  // Print with 2 decimal precision
    Serial.print(F(", \"phLevel\": "));
    Serial.print(phLevel, 2);              // Print with 2 decimal precision
    Serial.println(F("}"));

    delay(2000); // Delay 2 seconds before the next reading
}
