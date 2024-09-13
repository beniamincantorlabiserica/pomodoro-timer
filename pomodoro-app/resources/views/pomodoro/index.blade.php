<!-- resources/views/pomodoro/index.blade.php -->
<!DOCTYPE html>
<html lang="en" data-theme="garden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomodoro Emoji Tree Timer</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
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
        .progress-ring {
            transform: rotate(-90deg);
        }
    </style>
</head>
<body class="bg-base-200 min-h-screen flex flex-col">
<div class="container mx-auto px-4 py-8 flex-grow flex flex-col">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Pomodoro Tree Timer</h1>
        <label class="swap swap-rotate">
            <input type="checkbox" class="theme-controller" value="dark" />
            <svg class="swap-on fill-current w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>
            <svg class="swap-off fill-current w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
        </label>
    </div>
    <div class="card bg-base-100 shadow-xl flex-grow flex flex-col">
        <div class="card-body flex flex-col justify-between">
            <div class="flex flex-col lg:flex-row justify-between items-center">
                <div class="w-full lg:w-1/2 mb-4 lg:mb-0 flex flex-col items-center">
                    <div class="relative">
                        <svg class="progress-ring" width="260" height="260">
                            <circle class="progress-ring__circle" stroke="currentColor" stroke-width="8" fill="transparent" r="120" cx="130" cy="130"/>
                        </svg>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="giant-timer font-bold text-center" id="timer">25:00</div>
                            <div class="text-2xl text-center" id="status">Work Session</div>
                        </div>
                    </div>
                    <div class="stats shadow my-4">
                        <div class="stat">
                            <div class="stat-title">Work Sessions</div>
                            <div class="stat-value" id="workCount">0</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Breaks</div>
                            <div class="stat-value" id="breakCount">0</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Streak</div>
                            <div class="stat-value" id="streakCount">0</div>
                        </div>
                    </div>
                    <div class="form-control w-full max-w-xs mb-4">
                        <label class="label" for="taskInput">
                            <span class="label-text">Current Task:</span>
                        </label>
                        <input type="text" id="taskInput" placeholder="What are you working on?" class="input input-bordered w-full max-w-xs" />
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
                <div class="form-control">
                    <label class="label" for="soundToggle">
                        <span class="label-text">Sound:</span>
                    </label>
                    <input type="checkbox" id="soundToggle" class="toggle" checked />
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; {{ date("Y") }} Made with 🍎❤️ by Beniamin Avramita</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const timerDisplay = document.getElementById('timer');
        const statusDisplay = document.getElementById('status');
        const workCountDisplay = document.getElementById('workCount');
        const breakCountDisplay = document.getElementById('breakCount');
        const streakCountDisplay = document.getElementById('streakCount');
        const startBtn = document.getElementById('startBtn');
        const pauseBtn = document.getElementById('pauseBtn');
        const resetBtn = document.getElementById('resetBtn');
        const workDurationInput = document.getElementById('workDuration');
        const breakDurationInput = document.getElementById('breakDuration');
        const soundToggle = document.getElementById('soundToggle');
        const treeContainer = document.getElementById('treeContainer');
        const taskInput = document.getElementById('taskInput');
        const progressRing = document.querySelector('.progress-ring__circle');
        const radius = progressRing.r.baseVal.value;
        const circumference = radius * 2 * Math.PI;

        progressRing.style.strokeDasharray = `${circumference} ${circumference}`;
        progressRing.style.strokeDashoffset = circumference;

        let timer;
        let timeLeft;
        let totalTime;
        let isRunning = false;
        let isWorkSession = true;
        let workCount = 0;
        let breakCount = 0;
        let streakCount = 0;

        function setProgress(percent) {
            const offset = circumference - (percent / 100 * circumference);
            progressRing.style.strokeDashoffset = offset;
        }

        function updateDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            statusDisplay.textContent = isWorkSession ? 'Work Session' : 'Break Time';
            workCountDisplay.textContent = workCount;
            breakCountDisplay.textContent = breakCount;
            streakCountDisplay.textContent = streakCount;
            setProgress((1 - timeLeft / totalTime) * 100);
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
                            streakCount++;
                            addFruit();
                            confetti();
                            timeLeft = breakDurationInput.value * 60;
                            totalTime = timeLeft;
                            isWorkSession = false;
                        } else {
                            breakCount++;
                            timeLeft = workDurationInput.value * 60;
                            totalTime = timeLeft;
                            isWorkSession = true;
                        }
                        updateDisplay();
                        if (soundToggle.checked) {
                            new Audio('/path/to/your/sound.mp3').play();
                        }
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
            totalTime = timeLeft;
            isWorkSession = true;
            workCount = 0;
            breakCount = 0;
            streakCount = 0;
            updateDisplay();
            treeContainer.querySelectorAll('.fruit').forEach(fruit => fruit.remove());
        }

        startBtn.addEventListener('click', startTimer);
        pauseBtn.addEventListener('click', pauseTimer);
        resetBtn.addEventListener('click', resetTimer);

        workDurationInput.addEventListener('change', () => {
            if (!isRunning && isWorkSession) {
                timeLeft = workDurationInput.value * 60;
                totalTime = timeLeft;
                updateDisplay();
            }
        });

        breakDurationInput.addEventListener('change', () => {
            if (!isRunning && !isWorkSession) {
                timeLeft = breakDurationInput.value * 60;
                totalTime = timeLeft;
                updateDisplay();
            }
        });

        // Theme toggle
        const themeController = document.querySelector('.theme-controller');
        themeController.addEventListener('change', (e) => {
            if (e.target.checked) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'garden');
            }
        });

        // Task input
        taskInput.addEventListener('change', () => {
            localStorage.setItem('currentTask', taskInput.value);
        });

        // Load saved task
        const savedTask = localStorage.getItem('currentTask');
        if (savedTask) {
            taskInput.value = savedTask;
        }

        // Confetti function
        function triggerConfetti() {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        }

        // Initial setup
        timeLeft = workDurationInput.value * 60;
        totalTime = timeLeft;
        updateDisplay();
    });
</script>
</body>
</html>
