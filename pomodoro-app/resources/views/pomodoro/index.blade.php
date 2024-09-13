<!-- resources/views/pomodoro/index.blade.php -->
<!DOCTYPE html>
<html lang="en" data-theme="garden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomodoro Emoji Tree Timer</title>
    @vite('resources/css/app.css')
    <style>
        .tree-container {
            position: relative;
            width: 300px;
            height: 300px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .tree {
            font-size: 200px;
            z-index: 1;
        }
        .fruit {
            position: absolute;
            font-size: 24px;
            z-index: 2;
            transition: all 0.3s ease;
        }
        .giant-timer {
            font-size: 8rem;
            line-height: 1;
        }
        @media (max-width: 640px) {
            .giant-timer {
                font-size: 6rem;
            }
        }
        .footer {
            text-align: center;
            padding: 1rem;
            background-color: rgba(0, 0, 0, 0.1);
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-base-200 min-h-screen flex flex-col">
<div class="container mx-auto px-4 py-8 flex-grow flex flex-col">
    <h1 class="text-4xl font-bold text-center mb-8">Pomodoro Tree Timer</h1>
    <div class="card bg-base-100 shadow-xl flex-grow flex flex-col">
        <div class="card-body flex flex-col justify-between">
            <div class="flex flex-col lg:flex-row justify-between items-center">
                <div class="w-full lg:w-1/2 mb-4 lg:mb-0 flex flex-col items-center">
                    <div class="giant-timer font-bold text-center mb-4" id="timer">25:00</div>
                    <div class="text-2xl text-center mb-4" id="status">Work Session</div>
                    <div class="stats shadow mb-4">
                        <div class="stat">
                            <div class="stat-title">Work Sessions</div>
                            <div class="stat-value" id="workCount">0</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Breaks</div>
                            <div class="stat-value" id="breakCount">0</div>
                        </div>
                    </div>
                    <div class="card-actions justify-center">
                        <button class="btn btn-primary" id="startBtn">Start</button>
                        <button class="btn btn-warning" id="pauseBtn">Pause</button>
                        <button class="btn btn-error" id="resetBtn">Reset</button>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 flex justify-center">
                    <div class="tree-container" id="treeContainer">
                        <div class="tree">🌳</div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center space-x-4 mt-6">
                <div class="form-control">
                    <label class="label" for="workDuration">
                        <span class="label-text">Work (min):</span>
                    </label>
                    <input type="number" id="workDuration" value="25" min="1" class="input input-bordered w-20" />
                </div>
                <div class="form-control">
                    <label class="label" for="breakDuration">
                        <span class="label-text">Break (min):</span>
                    </label>
                    <input type="number" id="breakDuration" value="5" min="1" class="input input-bordered w-20" />
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <p class="text-center">&copy; {{ date("Y") }} Made with ❤️ by Beniamin Avramita</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const timerDisplay = document.getElementById('timer');
        const statusDisplay = document.getElementById('status');
        const workCountDisplay = document.getElementById('workCount');
        const breakCountDisplay = document.getElementById('breakCount');
        const startBtn = document.getElementById('startBtn');
        const pauseBtn = document.getElementById('pauseBtn');
        const resetBtn = document.getElementById('resetBtn');
        const workDurationInput = document.getElementById('workDuration');
        const breakDurationInput = document.getElementById('breakDuration');
        const treeContainer = document.getElementById('treeContainer');

        let timer;
        let timeLeft;
        let isRunning = false;
        let isWorkSession = true;
        let workCount = 0;
        let breakCount = 0;

        function updateDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            statusDisplay.textContent = isWorkSession ? 'Work Session' : 'Break Time';
            workCountDisplay.textContent = workCount;
            breakCountDisplay.textContent = breakCount;
        }

        function addFruit() {
            const fruit = document.createElement('div');
            fruit.className = 'fruit';
            fruit.textContent = '🍎';
            const angle = Math.random() * Math.PI * 2;
            const distance = Math.random() * 100 + 50;
            fruit.style.left = `calc(50% + ${Math.cos(angle) * distance}px - 12px)`;
            fruit.style.top = `calc(50% + ${Math.sin(angle) * distance}px - 12px)`;
            treeContainer.appendChild(fruit);
            setTimeout(() => fruit.style.transform = 'scale(1.2)', 50);
        }

        function startTimer() {
            if (!isRunning) {
                isRunning = true;
                timer = setInterval(() => {
                    if (timeLeft > 0) {
                        timeLeft--;
                        updateDisplay();
                    } else {
                        clearInterval(timer);
                        isRunning = false;
                        if (isWorkSession) {
                            workCount++;
                            addFruit();
                            timeLeft = breakDurationInput.value * 60;
                            isWorkSession = false;
                        } else {
                            breakCount++;
                            timeLeft = workDurationInput.value * 60;
                            isWorkSession = true;
                        }
                        updateDisplay();
                        new Audio('/path/to/your/sound.mp3').play(); // Add a sound file for notifications
                    }
                }, 1000);
            }
        }

        function pauseTimer() {
            clearInterval(timer);
            isRunning = false;
        }

        function resetTimer() {
            clearInterval(timer);
            isRunning = false;
            timeLeft = workDurationInput.value * 60;
            isWorkSession = true;
            workCount = 0;
            breakCount = 0;
            updateDisplay();
            // Clear all fruits
            treeContainer.querySelectorAll('.fruit').forEach(fruit => fruit.remove());
        }

        startBtn.addEventListener('click', startTimer);
        pauseBtn.addEventListener('click', pauseTimer);
        resetBtn.addEventListener('click', resetTimer);

        workDurationInput.addEventListener('change', () => {
            if (!isRunning && isWorkSession) {
                timeLeft = workDurationInput.value * 60;
                updateDisplay();
            }
        });

        breakDurationInput.addEventListener('change', () => {
            if (!isRunning && !isWorkSession) {
                timeLeft = breakDurationInput.value * 60;
                updateDisplay();
            }
        });

        // Initial setup
        timeLeft = workDurationInput.value * 60;
        updateDisplay();
    });
</script>
</body>
</html>
