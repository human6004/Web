const textarea = document.getElementById('myText');
const charCount = document.getElementById('charCount');
textarea.addEventListener('input', function() {
charCount.textContent = textarea.value.length;
});