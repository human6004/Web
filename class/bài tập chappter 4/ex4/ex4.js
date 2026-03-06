const images = ['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg'];
let currentIndex = 0;
const img = document.getElementById('galleryImg');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
nextBtn.addEventListener('click', function() {
currentIndex = (currentIndex + 1) % images.length;
img.src = images[currentIndex];
});
prevBtn.addEventListener('click', function() {
currentIndex = (currentIndex - 1 + images.length) % images.length;
img.src = images[currentIndex];
});
