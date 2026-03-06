const text = "Welcome! Learn JavaScript step by step.";
let index = 0;
function typeWriter() {
if (index < text.length) {
document.getElementById('typeText').textContent +=
text.charAt(index);
index++;
setTimeout(typeWriter, 100);
}
}
typeWriter();