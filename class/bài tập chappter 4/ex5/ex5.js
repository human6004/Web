let timeLeft = 10;
let timerInterval = null;

const timerDisplay = document.getElementById("timer");
const startBtn = document.getElementById("startBtn");

startBtn.addEventListener("click", function () {

    // Nếu đang chạy rồi thì không cho chạy tiếp
    if (timerInterval !== null) return;

    timeLeft = 10;

    timerInterval = setInterval(function () {

        timeLeft--;
        timerDisplay.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            timerInterval = null;
            alert("Time is up!");
            timerDisplay.textContent = 10;
        }

    }, 1000);

});