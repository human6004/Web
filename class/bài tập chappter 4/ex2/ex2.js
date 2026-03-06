const colorBtn = document.getElementById('colorBtn');
colorBtn.addEventListener('click', function() {
const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#FFA07A',
'#98D8C8', '#F7DC6F'];
const randomColor = colors[Math.floor(Math.random() *
colors.length)];
document.body.style.backgroundColor = randomColor;
});