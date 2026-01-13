# DAMS Dental Clinic Management System

DAMS Dental is a web-based platform designed to manage dental appointments and patient medical records. 
It features a student-centric dashboard for patients and a comprehensive management portal for administrators.

## Features
- **Patient Dashboard**: View upcoming appointments and full medical history.
- **Appointment System**: Book, cancel, and track dental services.
- **Medical Records**: Admins can securely add, edit, and delete patient diagnoses and treatments.
- **Role-Based Access**: Specialized views and permissions for Patients and Admins.

---

## Prerequisites
Before running this project, ensure you have the following installed:
- **PHP 8.2 or higher**
- **Composer**
- **MySQL**
- **Node.js & NPM**

## Installation Steps

1. **Clone the Repository**
   ```bash
   git clone <your-repository-link>
   cd <project-folder-name>
    ```
2. Install Dependencies

 ```bash

composer install
npm install
 ```
3. Environment Setup Copy the example environment file and generate a unique app key:

 ```bash

cp .env.example .env
php artisan key:generate
 ```
Database Configuration

4. Open .env and update the DB_DATABASE, DB_USERNAME, and DB_PASSWORD to match your local MySQL settings.

5. Run Migrations & Seeders

 ```Bash

php artisan migrate --seed
 ```
6. Compile Assets
 ```
 ```Bash

npm run dev
 ```
7. Start the Server

 ```Bash

php artisan serve
 ```
The application will be available at http://127.0.0.1:8000.
