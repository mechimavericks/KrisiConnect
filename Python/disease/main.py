from flask import Flask, request, render_template_string
from PIL import Image
import io
import os
from ultralytics import YOLO
from langchain.prompts import PromptTemplate
from langchain.chains import LLMChain
from langchain_google_genai import GoogleGenerativeAI

app = Flask(__name__)

model = YOLO("last.pt")

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
        3. उपचार विधिहरू (Treatment Methods)
        4. रोकथामका उपायहरू (Preventive Measures)
        5. रोगको छान्ने उपाय (Curing the disease)
        6. रोगको रोकथाम (Preventing the disease)
        7. रोगको उपचार विधिहरू (Treatment Methods)
        '''
    )
    llm = GoogleGenerativeAI(temperature=0.7, model="gemini-pro")
    summary_chain = LLMChain(llm=llm, prompt=summary_template, verbose=True)
    summary = summary_chain.run(disease=disease)
    return summary

@app.route('/', methods=['GET', 'POST'])
def predict_disease():
    if request.method == 'POST':
        if 'file' not in request.files:
            return 'No file part'
        
        file = request.files['file']
        if file.filename == '':
            return 'No selected file'
        
        if file:
            filepath = os.path.join(UPLOAD_FOLDER, file.filename)
            file.save(filepath)
            
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
                    'summary': summary
                })
            
            return render_template_string(result_template, predictions=formatted_predictions, image_file=file.filename)
    
    return render_template_string(index_template)

# HTML templates
index_template = '''
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Disease Prediction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #2c3e50;
        }
        form {
            margin-top: 20px;
        }
        input[type="file"] {
            display: block;
            margin: 10px auto;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Plant Disease Prediction</h1>
    <p>Upload an image of a plant leaf to predict potential diseases.</p>
    <form action="/" method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept="image/*" required>
        <input type="submit" value="Predict Disease">
    </form>
</body>
</html>
'''

result_template = '''
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediction Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        h1, h2 {
            color: #2c3e50;
        }
        img {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f1f1f1;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #2980b9;
        }
        .summary {
            text-align: left;
            white-space: pre-wrap;
            font-size: 0.9em;
            margin-top: 10px;
            padding: 10px;
            background-color: #e9e9e9;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Prediction Results</h1>
    <img src="{{ url_for('static', filename='uploads/' + image_file) }}" alt="Uploaded Image">
    <h2>Predictions:</h2>
    <ul>
    {% for pred in predictions %}
        <li>
            {{ pred.class }} 
            <div class="summary">{{ pred.summary }}</div>
        </li>
    {% endfor %}
    </ul>
    <a href="/">Back to Upload</a>
</body>
</html>
'''

if __name__ == '__main__':
    app.run(debug=True, port=49)
