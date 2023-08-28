<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Upload and Compression</title>
</head>
<body>
  <input type="file" id="imageInput" multiple>
  <button id="uploadButton">Upload</button>

  <script>
    document.getElementById('uploadButton').addEventListener('click', async () => {
      const imageInput = document.getElementById('imageInput');
      const selectedImages = Array.from(imageInput.files);

      if (selectedImages.length > 0) {
        const compressedImages = await Promise.all(selectedImages.map(compressImage));
        uploadCompressedImages(compressedImages);
      }
    });

    async function compressImage(imageFile) {
      const reader = new FileReader();

      return new Promise((resolve, reject) => {
        reader.onload = (event) => {
          const img = new Image();
          img.src = event.target.result;
          img.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0, img.width, img.height);

            const base64Data = canvas.toDataURL('image/jpeg', 0.7); 
            resolve(base64Data);
          };
        };
        reader.readAsDataURL(imageFile);
      });
    }

    function uploadCompressedImages(compressedImages) {
      const formData = new FormData();

      compressedImages.forEach((base64Image, index) => {
        const blob = dataURItoBlob(base64Image);
        formData.append(`compressedImage${index}`, blob, `image${index}.jpg`);
      });

      fetch('demo2.php', {
        method: 'POST',
        body: formData,
      })
      .then(response => response.text())
      .then(result => console.log(result))
      .catch(error => console.error(error));
    }

    function dataURItoBlob(dataURI) {
      const byteString = atob(dataURI.split(',')[1]);
      const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
      const ab = new ArrayBuffer(byteString.length);
      const ia = new Uint8Array(ab);

      for (let i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
      }

      return new Blob([ab], { type: mimeString });
    }
  </script>
</body>
</html>
