document.addEventListener('DOMContentLoaded', function () {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('articleImage');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const imageInfo = document.getElementById('imageInfo');
    const removeImageBtn = document.getElementById('removeImageBtn');

    if (!uploadArea || !fileInput) return;

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function (event) {
            imagePreview.src = event.target.result;
            imageInfo.textContent = `${file.name} • ${(file.size / 1024 / 1024).toFixed(2)} MB`;
            imagePreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    uploadArea.addEventListener('click', function () {
        fileInput.click();
    });

    fileInput.addEventListener('change', function () {
        if (fileInput.files && fileInput.files[0]) {
            showPreview(fileInput.files[0]);
        }
    });

    ['dragenter', 'dragover'].forEach(function (eventName) {
        uploadArea.addEventListener(eventName, function (event) {
            event.preventDefault();
            uploadArea.classList.add('drag-over');
        });
    });

    ['dragleave', 'drop'].forEach(function (eventName) {
        uploadArea.addEventListener(eventName, function (event) {
            event.preventDefault();
            uploadArea.classList.remove('drag-over');
        });
    });

    uploadArea.addEventListener('drop', function (event) {
        const files = event.dataTransfer.files;
        if (files && files.length > 0) {
            fileInput.files = files;
            showPreview(files[0]);
        }
    });

    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function () {
            fileInput.value = '';
            imagePreview.src = '';
            imageInfo.textContent = '';
            imagePreviewContainer.style.display = 'none';
        });
    }
});
