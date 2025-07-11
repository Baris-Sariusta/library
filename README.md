<p align="center">
  <img height="200px" src="https://raw.githubusercontent.com/Bariss61/library/refs/heads/feature/add-readme/assets/banner-library.png?token=GHSAT0AAAAAADGT3BLG6EKH7IE4JAC4EF3C2DRQJMQ" alt="Library App Banner">
</p>

<p align="center">
  📚 A modern Laravel 12 library application in a clean and scalable way.
</p>

<p align="center">
  <a href="https://github.com/Bariss61/library/actions"><img alt="Tests" src="https://github.com/Bariss61/library/actions/workflows/run-tests.yml/badge.svg"></a>
  <a href="https://github.com/Bariss61/library"><img alt="PHP version" src="https://img.shields.io/badge/PHP-^8.2-blue.svg"></a>
  <a href="https://github.com/Bariss61/library"><img alt="Laravel" src="https://img.shields.io/badge/Laravel-12-red"></a>
  <a href="https://github.com/Bariss61/library/blob/main/LICENSE"><img alt="License" src="https://img.shields.io/github/license/your-username/your-repo"></a>
</p>

---

## 📝 Description

I started this project to improve my Laravel skills. My goal is to explore all parts of the framework, touch on every aspect of Laravel, 
and become a better developer by learning from my mistakes along the way.

In this project, I try to implement as many best practices as possible, focusing on clean code, separation of concerns, and maintainability. 
As a junior developer, I still have a lot to learn, and this project is a great way for me to grow and challenge myself in a practical way.

---

## 🚀 Features

- REST API for managing books, authors and genres
- API authentication with Laravel Sanctum
- Role based access control (librarian, manager, admin)
- Modern and extendable architecture
- Feature, Unit and Architecture tests using Pest
---

## ⚙️ Installation

```bash
git clone https://github.com/Bariss61/library.git
cd library
composer install
cp .env.example .env # Create own local env file
php artisan key:generate # Generate app encryption key
php artisan migrate --seed
php artisan serve
```
