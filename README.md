#
# FOOD SHARING WEB APPLICATION (FINAL YEAR PROJECT – BSc COMPUTER SCIENCE)
#

**Framework:** Laravel 10 (PHP 8)
**Language:** PHP, Blade (HTML/CSS/JS)  
**Database:** MySQL  
**Category:** Full-Stack Web Application Project  

---

## 1. PROJECT DESCRIPTION

* This project is a **community-oriented food sharing web application** developed as part of a final-year BSc Computer Science project.  
* The system is designed to help individuals and local businesses reduce food waste by enabling users to **share surplus food** with others in their community.  
* Registered users can create, update, and delete food listings, while others can browse, reserve, and collect available items.  
* The application provides **secure authentication, CRUD operations, email notifications, and an admin dashboard** for platform moderation.  
* Developed using **Laravel’s MVC framework**, it integrates a **relational database (MySQL)** and **Blade templates** for dynamic content rendering.  
* The design emphasizes sustainability, scalability, and accessibility through a fully responsive interface.

---

## 2. FEATURES

* User registration, login, and authentication (Laravel Breeze / Sanctum)  
* Create, edit, and delete food listings  
* Upload and manage food images  
* Reservation and confirmation workflow  
* Automated email notifications for reservations  
* Admin dashboard for managing listings and users  
* Category and location-based search and filtering  
* Responsive front-end built with Bootstrap 5  
* Database migration and seeding support  
* Unit and feature tests using PHPUnit  

---

## 3. FILE STRUCTURE

```
app/               → Controllers, Models, Middleware, and business logic
bootstrap/         → Application bootstrapping files
config/            → Configuration files (app, mail, database)
database/          → Migrations and Seeders
public/            → Public assets (CSS, JS, images)
resources/         → Blade templates and front-end views
routes/            → Web and API route definitions
storage/           → Uploaded images, logs, and cache
tests/             → Unit and feature tests
.env.example       → Example environment configuration
composer.json      → PHP dependencies
artisan            → Laravel CLI tool
README.md          → Project documentation
```

---

## 4. SETUP AND INSTALLATION

1. **Clone the repository:**

   ```bash
   git clone https://github.com/Aliy7/food-sharing-app.git
   cd food-sharing-app
   ```

2. **Install dependencies:**

   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Configure the environment:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Then update the `.env` file with your **database** and **mail** credentials.

4. **Run database migrations and seeders:**

   ```bash
   php artisan migrate --seed
   ```

5. **Start the local development server:**

   ```bash
   php artisan serve
   ```

   Access the application at: https://foodsharing.io

---

## 5. USAGE GUIDE

### Register and Login
Create an account and sign in to access the user dashboard.

### Create a Food Listing
Submit available food with title, description, expiry date, and optional image.

### Make a Reservation
Browse available listings and reserve an item for collection.  
Both donor and receiver receive confirmation via email.

### Manage Listings
Users can update or delete their listings anytime from their dashboard.

### Admin Dashboard
Admins can view all users, monitor listings, and approve or remove inappropriate content.

---

## 6. EMAIL NOTIFICATIONS

The application uses Laravel’s built-in `Mail` functionality.  
Configure SMTP credentials in `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

Emails are triggered automatically when reservations are made or confirmed.

---

## 7. TESTING

To execute automated tests, run:

```bash
php artisan test
```

Expected result:

```
All tests passed (✔)
```

The testing suite includes:  
* Authentication and user registration tests  
* Food listing creation and deletion tests  
* Reservation workflow verification  
* Email dispatch validation  

---

## 8. CONCLUSION

The **Food Sharing Web Application** demonstrates robust use of the Laravel framework to create a socially impactful platform.  
It successfully integrates authentication, CRUD operations, and automated notifications while maintaining clean architecture and scalability.  
The project aligns with sustainable development goals by addressing food waste and community engagement through modern web technologies.

**----End----**
