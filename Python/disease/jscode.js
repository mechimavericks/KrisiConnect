const formdata = new FormData();
formdata.append("file", fileInput.files[0], "image.png");

const requestOptions = {
  method: "POST",
  body: formdata,
  redirect: "follow"
};

fetch("http://127.0.0.1:8000/predict/", requestOptions)
  .then((response) => response.text())
  .then((result) => console.log(result))
  .catch((error) => console.error(error));