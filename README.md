## DAMS Dental Clinic Management System

DAMS Dental is a web-based platform designed to manage dental appointments and patient medical records. It features a student-centric dashboard for patients and a comprehensive management portal for administrators.

## Features
- Patient Dashboard: View upcoming appointments and full medical history.

- Appointment System: Book, cancel, and track dental services.

- Medical Records: Admins can securely add, edit, and delete patient diagnoses and treatments.

- Role-Based Access: Specialized views and permissions for Patients and Admins.

##  Prerequisites

To run this project easily, we recommend using Laragon, which bundles the necessary tools (PHP, MySQL, Web Server).

Node.js & NPM (Usually included in Laragon, but ensure you have a recent version installed)



Installation Steps (Using Laragon)

## 1. Prepare the Environment
Open Laragon.

Click Start All to initialize the Apache/Nginx server and MySQL database.

Click on the Terminal button in Laragon to open the command line.



## 2. Install Dependencies
Enter the project folder and install the backend and frontend dependencies.

```bash
cd <project-folder-name>
composer install
npm install
```

## 3. Environment Setup
Copy the example environment file and generate a unique app key.

```bash
cp .env.example .env
php artisan key:generate
```
## 4. Database Configuration
Open Laragon and click the Database button to open HeidiSQL (or your preferred manager).

Create a new empty database (e.g., named dams_db).

Open the .env file in your project code and update the database settings to match:

Code snippet
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dams_db
DB_USERNAME=root
DB_PASSWORD=       # Leave empty if using default Laragon settings
```

## 5. Email Configuration (Crucial for Notifications)
To allow the system to send appointment emails, you must configure the SMTP settings in your .env file.

Open the .env file.

Locate the MAIL_ variables.

Update them with your email provider's credentials.

Note: If you are using Gmail, you cannot use your standard login password. You must enable 2-Step Verification on your Google Account and generate an App Password.

Example Configuration (for Gmail):

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email-address@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@dams-dental.com"
MAIL_FROM_NAME="${APP_NAME}"
```
## 6. Run Migrations & Seeders
Populate the database with the necessary tables and test data.
```bash
php artisan migrate --seed
```

## 7. Compile Assets
Build the frontend assets (CSS/JS).
```
npm run dev

```

## 8. Start the Queue Worker

This application uses a queue system for background tasks (e.g., sending appointment emails, processing notifications). You must keep a worker running to process these tasks.

Open a separate Laragon Terminal tab (Menu > Tools > Terminal) and run:
```bash
php artisan queue:work
```
Important: Keep this terminal window open while using the application. If you close it, emails and background updates will not process.

## 9. How to Access the Application
```
php artisan serve
```

The application will be available at http://127.0.0.1:8000.

Ensure Laragon is running ("Start All") and the queue:work terminal is active.
127.0.0.1

## Tech Stack

Framework: Laravel 12
Frontend: Tailwind CSS (Styling), Alpine.js (Interactivity), and Blade (Templating).
Backend: PHP 8.3 and MySQL (Database).
