from ultralytics import YOLO

model = YOLO("last.pt")

test_img = "image.png"

results = model(source=test_img, show=True, save=True)
