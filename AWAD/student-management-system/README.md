# BUC3131: MUBS Student Management System (SMS)

A web-based academic administration platform developed for Makerere University Business School (MUBS) under course unit BUC3131. The system streamlines student records management, course enrollment, lecturer course view, role-based authentication, and academic reporting.

---

## 1. Project & Repository Details

- Course Unit: BUC3131 - Advanced Web Application Development (SMS)
- Institution: Makerere University Business School (MUBS)
- Repository URL: https://github.com/ZZIWA-FRANCIS/mubs-student-management-system.git
- Framework: Laravel (PHP)
- Frontend: Tailwind CSS & Blade Templates (Vite Asset Bundler)
- Database: MySQL

---

## 2. Team Members & Repository Contributors

| Name | Student Role | GitHub Username | Email / Student No. |
| :--- | :--- | :--- | :--- |
| Zziwa Francis | Project Lead / Repository Owner | ZZIWA-FRANCIS | 2400720799 |
| Kibirango Ben | Database & Asset Lead | kibirangoben-collab | kibirangoben67@gmail.com |
| Nakawooya Flavia | Views & Controller Lead | Nakawooya-Flavia | nakawooyaflavia1@gmail.com |

---

## 3. Sample Evaluation Credentials

Use the pre-seeded account credentials below to test individual role permissions, middleware access, and dashboard views:

| System Role | Email Address | Default Password | Designed Application Functionality |
| :--- | :--- | :--- | :--- |
| Administrator | admin@mubs.ac.ug | password123 | Manages students, courses, registrations, and user access. |
| Lecturer | jdoe@mubs.ac.ug | password123 | Views assigned courses and registered students. |
| Student | student1@mubs.ac.ug | password123 | Views available courses and own registrations. |

---

## 4. Key Features & Architectural Modules

1. Authentication & Role Management: Secure user login, session protection, CSRF middleware verification, and role-based access control (Admin, Lecturer, Student).
2. Eloquent Database Relationships: Configured One-to-Many (`hasMany`), Belongs-To (`belongsTo`), and Many-to-Many (`belongsToMany`) relationships across Students, Courses, and Registrations.
3. Controllers & Blade Views: Dynamic controller logic handling student and course CRUD operations, registration validation, and responsive Blade UI interface.
4. Database Seeders & Migrations: Structured database schema migrations with automated test data generation and role seeding.

---

## 5. Local Installation & Setup Guide

Execute the following sequential steps in your terminal to set up and launch the application locally:

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL / XAMPP Server

### Installation Steps

1. Clone the central GitHub repository:
   git clone https://github.com/ZZIWA-FRANCIS/mubs-student-management-system.git

2. Navigate into the project root directory:
   cd mubs-student-management-system

3. Install PHP dependencies:
   composer install

4. Install JavaScript dependencies & compile frontend assets:
   npm install
   npm run build

5. Create environment configuration file:
   cp .env.example .env

6. Generate application security key:
   php artisan key:generate

7. Configure MySQL database details inside the `.env` file:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mubs_sms
   DB_USERNAME=root
   DB_PASSWORD=

8. Run database migrations and seed default evaluation credentials:
   php artisan migrate --seed

9. Launch local development server:
   php artisan serve

10. Access application in your browser at `http://127.0.0.1:8000`.

---

## 6. Project Structure Overview

- `app/Http/Controllers/`: Contains request processing logic for student, admin, lecturer, and course registration routes.
- `app/Models/`: Defines Eloquent data models and relationships (`User`, `Student`, `Course`, `CourseRegistration`).
- `database/migrations/`: Database table schema definitions.
- `database/seeders/`: Pre-seeded default users, roles, permissions, and test records.
- `resources/views/`: Blade templates for user dashboards, navigation layout, and application forms.
- `routes/web.php`: System routing definitions protected by authentication and authorization middleware.
-