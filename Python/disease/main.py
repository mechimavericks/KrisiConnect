from ultralytics import YOLO

model = YOLO("best.pt")

model.eval()

model.predict("test.jpg", save=True)

