function showImage() {
    var selectedValue = document.querySelector('select[name="section"]').value;
    var demoImageContainer = document.querySelector(".demo-image");

    if (!selectedValue) {
        demoImageContainer.style.display = "none";
        return;
    }

    demoImageContainer.style.display = "block";

    var imagePath = "/backend/section_style";
    var imageName = selectedValue + ".jpg";

    var imageContainer = document.getElementById("image-container");
    var imageElement = document.getElementById("image-to-show");
    var messageContainer = document.getElementById("image-message");

    var imageSrc = imagePath + "/" + imageName;

    var img = new Image();
    img.onload = function () {
        imageElement.src = imageSrc;
        imageContainer.style.display = "block";
        messageContainer.style.display = "none";
    };
    img.onerror = function () {
        imageContainer.style.display = "none";
        messageContainer.style.display = "block";
    };
    img.src = imageSrc;
}

// Automatically call showImage when the page loads
document.addEventListener("DOMContentLoaded", function () {
    var selectedValue = document.querySelector('select[name="section"]').value;
    if (selectedValue) {
        showImage();
    }
});
