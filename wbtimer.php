<!DOCTYPE html>
<html>
<head>
    <title>Work/Break Timer</title>
    <style>
        body {
            text-align: center;
            font-family: Arial;
            transition: background-color 0.5s;
        }
        #timer {
            font-size: 48px;
            margin-top: 30px;
        }
        input {
            font-size: 18px;
            padding: 5px;
            margin: 5px;
        }
        button {
            font-size: 20px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>

<h1>⏱ Work & Break Timer</h1>

<form id="timerForm">
    <label>Work Time (minutes): <input type="number" id="workTime" required></label><br>
    <label>Break Time (minutes): <input type="number" id="breakTime" required></label><br>
    <button type="submit">Start Timer</button>
</form>

<div id="status"></div>
<div id="timer"></div>

<script>
let isWork = true;
let timerInterval;

document.getElementById("timerForm").addEventListener("submit", function(e) {
    e.preventDefault();
    clearInterval(timerInterval); // Reset if restarting

    const workMinutes = parseInt(document.getElementById("workTime").value);
    const breakMinutes = parseInt(document.getElementById("breakTime").value);

    if (isNaN(workMinutes) || isNaN(breakMinutes) || workMinutes <= 0 || breakMinutes <= 0) {
        alert("Please enter valid positive numbers.");
        return;
    }

    startTimer(workMinutes, breakMinutes);
});

function startTimer(workMins, breakMins) {
    function switchTimer(duration, label, color) {
        document.body.style.backgroundColor = color;
        document.getElementById("status").textContent = label;
        let endTime = new Date().getTime() + duration * 60 * 1000;

        timerInterval = setInterval(function() {
            let now = new Date().getTime();
            let remaining = endTime - now;

            if (remaining <= 0) {
                clearInterval(timerInterval);
                isWork = !isWork;
                switchTimer(isWork ? workMins : breakMins, isWork ? "Work Time" : "Break Time", isWork ? "purple" : "green");
                return;
            }

            let mins = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
            let secs = Math.floor((remaining % (1000 * 60)) / 1000);
            document.getElementById("timer").textContent = `${mins}m ${secs < 10 ? '0' + secs : secs}s`;
        }, 1000);
    }

    isWork = true;
    switchTimer(workMins, "Work Time", "purple");
}
</script>

</body>
</html>
