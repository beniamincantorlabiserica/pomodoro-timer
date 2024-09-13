# 🍎 Pomodoro Tree Timer 🌳

Welcome to the Pomodoro Tree Timer, a delightful and productive way to manage your work and break sessions! 

## 🌟 Features

- ⏲️ Customizable work and break durations
- 🌳 Visual tree growth to represent your progress
- 🍎 Earn an apple for each completed work session
- 📊 Track your work sessions and breaks
- 🎨 Beautiful, responsive design using DaisyUI and Tailwind CSS
- 🔔 Audio notifications for session completions

## 🚀 Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and npm

### Installation

1. Clone the repository:
   ```
   git clone https://github.com/beniamincantorlabiserica/pomodoro-tree-timer.git
   cd pomodoro-tree-timer
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Copy the `.env.example` file to `.env` and configure your environment variables:
   ```
   cp .env.example .env
   ```

5. Generate an application key:
   ```
   php artisan key:generate
   ```

6. Compile assets:
   ```
   npm run dev
   ```

7. Start the development server:
   ```
   php artisan serve
   ```

## 🍅 How to Use

1. Set your desired work and break durations (default is 25 minutes work, 5 minutes break).
2. Click 'Start' to begin your work session.
3. Focus on your task until the timer ends.
4. Enjoy a break when the work session completes - you've earned an apple on your tree! 🍎
5. Repeat the process and watch your productivity tree grow!

## 🌿 The Pomodoro Technique

The Pomodoro Technique is a time management method developed by Francesco Cirillo in the late 1980s. It uses a timer to break work into intervals, traditionally 25 minutes in length, separated by short breaks. Each interval is known as a pomodoro, from the Italian word for tomato, after the tomato-shaped kitchen timer Cirillo used as a university student.

## 🎨 Customization

Feel free to adjust the DaisyUI theme by changing the `data-theme` attribute in the HTML tag. You can also modify the tree emoji or apple emoji to fit your preferences!

## 🤝 Contributing

Contributions, issues, and feature requests are welcome! Feel free to check the [issues page](https://github.com/yourusername/pomodoro-tree-timer/issues).

## 📜 License

This project is [MIT](https://choosealicense.com/licenses/mit/) licensed.

## 🙏 Acknowledgements

- [Laravel](https://laravel.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [DaisyUI](https://daisyui.com/)
- [The Pomodoro Technique](https://francescocirillo.com/pages/pomodoro-technique)

---

Made with 🍎❤️ by Beniamin Avramita
