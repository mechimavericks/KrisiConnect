# KrisiConnect

## Introduction

Krisi Connect is an innovative agricultural platform designed to bridge the gap between farmers, agricultural experts, and consumers. The app provides farmers with real-time market prices, weather updates, and expert advice, while also serving as a direct connection between farmers and buyers, ensuring fair pricing and reduced reliance on middlemen.

A key feature of Krisi Connect is its integration with IoT technology, utilizing pH sensors and soil moisture sensors connected via Arduino. These devices help farmers monitor soil health and moisture levels, providing real-time data to optimize farming practices and improve crop yields. This modern approach empowers farmers with accurate, data-driven insights, fostering sustainable farming practices.

The platform also offers a community space for knowledge sharing, resources on the latest agricultural technologies, and multi-language support in both Nepali and English, making it accessible to a wide range of users.

# Krisi Connect Features

## 1. Real-Time Market Prices

- Access up-to-date market prices for crops, helping farmers make informed decisions.

## 2. Weather Updates

- Receive real-time weather forecasts, helping farmers plan their activities efficiently.

## 3. Expert Farming Advice

- Connect with agricultural experts for insights on sustainable farming techniques, crop management, and best practices.

## 4. IoT Integration for Smart Farming

- **pH Sensors**: Monitor the pH level of soil in real-time to ensure optimal soil conditions for different crops.
- **Soil Moisture Sensors**: Get real-time data on soil moisture levels, enabling farmers to manage irrigation more efficiently.
- **Arduino Integration**: The IoT sensors are connected via Arduino, providing accurate data to help improve farming outcomes.

## 5. Direct Farmer-to-Buyer Connection

- Farmers can connect directly with buyers, reducing the need for middlemen and ensuring fair prices for produce.

## 6. Agricultural Resources

- Access a wide range of resources on the latest agricultural technologies and innovations, helping farmers stay updated.

## 7. Sustainable Farming Solutions

- Promotes sustainable farming by offering expert advice and insights, along with IoT data, to help farmers make eco-friendly decisions.

# Krisi Connect Tech Stack

## 1. Laravel for PWA

- **Laravel** is used to build the Progressive Web Application (PWA) for _Krisi Connect_. It provides a robust backend framework that handles user management, data processing, and dynamic content delivery.

## 2. Python for API and Models

- **Python** is utilized to create the APIs that interact with the frontend and manage data flow between different components. Additionally, Python powers the machine learning models integrated into the platform, enabling real-time analysis and smart farming insights.

## 3. YOLOv8 for Model Training

- **YOLOv8 (You Only Look Once)** is used for training machine learning models, specifically for object detection and analysis. The training takes place on **Google Colab**, leveraging cloud GPU resources for efficient model training.

## 4. LangChain for Intelligent Conversations

- **LangChain** is incorporated to handle natural language processing (NLP) tasks and conversational AI. It enables smart interactions between users and the platform, providing personalized recommendations and responses.

## 5. Arduino IDE for IoT Integration

- The **Arduino IDE** is used to program the Arduino devices connected to pH and soil moisture sensors. This allows real-time monitoring of agricultural data, which is integrated with the platform for actionable insights.

# How Krisi Connect Works

## 1. User Access and Dashboard

- Farmers, buyers, and agricultural experts can create accounts and log in to the platform.
- Upon login, users are greeted with a dashboard that provides personalized information based on their role (e.g., market prices, weather updates, expert advice, etc.).

## 2. Real-Time Market Data and Weather Updates

- The platform fetches **real-time market prices** and **weather forecasts** from external APIs, which are displayed on the farmer's dashboard to help them make informed decisions.
- Users can view and track prices of specific crops and get alerts on weather changes relevant to their farming activities.

## 3. IoT Data Collection and Monitoring

- **pH sensors** and **soil moisture sensors** are deployed on the farm, connected via Arduino.
- The data from these sensors is sent to the platform in real-time, providing farmers with insights into soil conditions.
- Farmers can monitor and adjust their farming practices (e.g., irrigation) based on the sensor data displayed on their dashboard.

## 4. AI-Powered Farming Insights

- The platform uses **Python-based APIs** to process IoT data and run machine learning models.
- These models, trained with **YOLOv8** on **Google Colab**, analyze environmental conditions and provide suggestions to optimize crop yield.
- Farmers receive notifications and recommendations based on this analysis, helping them make data-driven decisions.

## 5. Direct Farmer-to-Buyer Connection

- Farmers can list their crops for sale, and buyers can directly connect with them through the platform.
- By facilitating direct interactions, _Krisi Connect_ reduces the dependency on middlemen, allowing farmers to receive fair prices for their produce.

## 6. Expert Advice and Community Support

- Farmers can ask questions and seek advice from agricultural experts integrated into the platform.
- A community forum enables users to share experiences, advice, and success stories, building a collaborative farming network.

## 7. Natural Language Processing (NLP) via LangChain

- The platform incorporates **LangChain** to process natural language queries.
- Farmers can ask questions related to farming techniques, crop management, or troubleshooting issues, and receive intelligent responses tailored to their needs.

## 8. Progressive Web Application (PWA)

- The platform is built as a **Progressive Web Application (PWA)** using **Laravel**, allowing users to access the app from any device, with features like offline access, push notifications, and fast load times.

## 9. Seamless Integration with IoT Devices

- The platform uses the **Arduino IDE** to program the IoT devices (pH and soil moisture sensors).
- These devices communicate with the backend, enabling the platform to provide real-time insights based on the soil data collected from the farm.

# Challenges Faced in Krisi Connect Development

## 1. Model Training with YOLOv8

### a. Data Collection and Labeling

- **Challenge**: Gathering a diverse and comprehensive dataset for training object detection models using **YOLOv8** was a significant hurdle.
- **Solution**: We spent considerable time collecting and labeling data to ensure accurate detection of various agricultural conditions and scenarios, such as crop health, pests, and soil conditions.

### b. Computing Resources

- **Challenge**: Training complex models like **YOLOv8** requires high computational resources, which can be limited on local machines.
- **Solution**: We leveraged **Google Colab's** cloud GPU resources for efficient training, although managing training time and optimizing for GPU usage was a challenge due to limited session durations.

### c. Model Accuracy and Fine-Tuning

- **Challenge**: Achieving high model accuracy for agricultural conditions was difficult due to varying environments and external factors like lighting and weather conditions.
- **Solution**: We iteratively fine-tuned the model with additional data augmentation techniques and experimented with hyperparameter tuning to improve accuracy, but it required significant trial and error.

## 2. Setting Up IoT Devices

### a. Sensor Calibration

- **Challenge**: Ensuring the accuracy of the **pH sensors** and **soil moisture sensors** was a challenge, as the devices needed to be calibrated correctly to give reliable data.
- **Solution**: We performed multiple rounds of calibration in different soil types and environmental conditions to ensure accurate readings. Each calibration had to be checked against industry standards for precision.

### b. Real-Time Data Transmission

- **Challenge**: Transmitting data from the IoT sensors to the platform in real time required reliable connectivity and integration between the sensors, the **Arduino** controller, and the web platform.
- **Solution**: We optimized the communication protocols to reduce data transmission delays and implemented error handling mechanisms to ensure data integrity during transmission.

To install and configure KrisiConnect, follow these steps:

### Prerequisites

- Node.js and npm (Node Package Manager) installed on your machine.
- Python and pip (Python Package Manager) installed on your machine.
- Git installed on your machine.
- Access to the KrisiConnect GitHub repository.

# Prerequisites and Setup Guide for Krisi Connect

## 1. Prerequisites

### a. Software Requirements

- **Laravel Framework**: Version 8 or later for building and running the Progressive Web App (PWA).
- **Python**: Version 3.8 or later, with necessary libraries like Flask, FastAPI for API development, and machine learning libraries (e.g., TensorFlow, PyTorch).
- **YOLOv8**: Installed on **Google Colab** or a local machine with GPU support for model training.
- **LangChain**: Python library for natural language processing (NLP) tasks.
- **Arduino IDE**: For programming IoT devices connected to the platform.
- **Node.js**: For running the JavaScript dependencies in the frontend of the web application.

### b. Hardware Requirements

- **IoT Devices**:
  - pH sensor
  - Soil moisture sensor
- **Arduino Board**: Compatible with the sensors (e.g., Arduino Uno or Nano).
- **Internet Connection**: Stable connection for real-time data transmission from IoT sensors to the platform.

### c. Additional Tools

- **Google Colab**: To train machine learning models using cloud GPUs.
- **Git**: Version control for managing project code.

---

## 2. Setup Guide

### a. Cloning the Repository

1. Open a terminal and clone the **Krisi Connect** project repository from GitHub:
   ```bash
   git clone https://github.com/santoshvandari/krisiconnect.git
   ```
2. Navigate to the project directory:
   ```bash
   cd krisiconnect
   ```

### b. Backend Setup (Laravel)

1. Install the Laravel dependencies using Composer:
   ```bash
   composer install
   ```
2. Copy the `.env` file and set up environment variables for your database, APIs, etc.:
   ```bash
   cp .env.example .env
   ```
3. Generate the application key:
   ```bash
   php artisan key:generate
   ```
4. Run database migrations to set up the required tables:
   ```bash
   php artisan migrate
   ```
5. Start the Laravel development server:
   ```bash
   php artisan serve
   ```

### c. Python API and Model Setup

1. Set up a Python virtual environment:
   ```bash
   python3 -m venv venv
   source venv/bin/activate
   ```
2. Install the required Python dependencies:
   ```bash
   pip install -r requirements.txt
   ```
3. Run the Python API server to handle requests from the frontend:
   ```bash
   fastapi dev main.py
   ```

### d. Model Training with YOLOv8 (Optional)

1. Open **Google Colab** and upload the training dataset.
2. Install the required YOLOv8 libraries by running the following in a Colab notebook:
   ```python
   !pip install ultralytics
   ```
3. Train the model:
   ```python
   from ultralytics import YOLO
   model = YOLO('disease.pt')
   model.train(data='data.yaml', epochs=50)
   ```
4. Export the trained model and integrate it into the backend for real-time inference.

### e. Arduino and IoT Setup

1. Install the **Arduino IDE** from the official Arduino website.
2. Connect the **pH sensor** and **soil moisture sensor** to the Arduino board.
3. Write the Arduino code for reading data from the sensors and uploading it to the web platform using HTTP requests:
   ```cpp
   // Example code to read from the sensor
   int sensorValue = analogRead(A0);
   ```
4. Upload the code to the Arduino board via the Arduino IDE.
5. Ensure the board is connected to the network and data is transmitted to the Laravel backend.

### f. Frontend Setup

1. Install the JavaScript dependencies:
   ```bash
   npm install
   ```
2. Start the frontend development server:
   ```bash
   npm run dev
   ```

---

### g. Running the Application

- With the Laravel backend, Python APIs, and Arduino sensors properly set up, you can access the **Krisi Connect** platform in your browser:
  ```bash
  http://localhost:8000
  ```

### h. Optional: Deploying the Application

1. Use **Heroku**, **Vercel**, or another hosting provider for deployment.
2. Set up continuous deployment with **Git** to keep your app updated.

## Support and Contact

For any questions, support, or inquiries, please contact our team at [meprazhant@gmail.com](mailto:meprazhant@gmail.com), [sanketshiwakoti2@gmail.com](mailto:sanketshiwakoti2@gmail.com), [shameerkharel2@gmail.com](mailto:shameerkharel2@gmail.com), [santoshvandari100@gmail.com](mailto:santoshvandari100@gmail.com)

## License

KrisiConnect is released as an open-source collaboration and customization.

## Disclaimer

KrisiConnect is a tool designed to enhance highway safety, but it is not a replacement for responsible driving and existing safety measures. Always prioritize safe driving practices and follow local traffic laws when using the road.
