from flask import Flask, request, render_template, send_file
from ultralytics import YOLO
import os

app = Flask(__name__)
model = YOLO("last.pt")

@app.route('/', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        file = request.files['file']
        if file:
            file_path = os.path.join('uploads', file.filename)
            file.save(file_path)
            
            results = model(source=file_path, show=False, save=True, conf=0.5)
            detected_img_path = results.save_dir / file.filename
            
            return send_file(detected_img_path, mimetype='image/png')
    return render_template('upload.html')


if __name__ == '__main__':
    app.run(port=49)
