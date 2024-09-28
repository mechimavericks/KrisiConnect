from flask import Flask, request, render_template_string

app = Flask(__name__)

def convert_a_to_b(a):
    if a >= 98.9:
        return 7
    elif a < 0:
        return 14
    else:
        return 14 - (14 * a / 98.9)

form_html = """
<!DOCTYPE html>
<html>
<head>
    <title>Convert A to B</title>
</head>
<body>
    <h1>Convert A to B</h1>
    <form action="/convert" method="post">
        <label for="a_value">Enter a value (0-99):</label>
        <input type="number" id="a_value" name="a_value" step="0.1" min="0" max="99" required>
        <button type="submit">Convert</button>
    </form>
</body>
</html>
"""

result_html = """
<!DOCTYPE html>
<html>
<head>
    <title>Conversion Result</title>
</head>
<body>
    <h1>Conversion Result</h1>
    <p>Input value (A): {{ a_value }}</p>
    <p>Converted value (B): {{ b_value }}</p>
    <a href="/">Convert another value</a>
</body>
</html>
"""

@app.route("/", methods=["GET"])
def read_form():
    return render_template_string(form_html)

@app.route("/convert", methods=["POST"])
def handle_form():
    a_value = float(request.form["a_value"])
    b_value = convert_a_to_b(a_value)
    return render_template_string(result_html, a_value=a_value, b_value=b_value)

if __name__ == "__main__":
    app.run(debug=True)