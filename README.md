# FleetFind API

This is the backend API for the FleetFind application. It is built using Laravel 13, Livewire (for the authentication scaffold), Vite with Sass/SCSS preprocessor for styling, and MySQL for the database.

---

## Requirements

Ensure you have the following installed on your local machine:
- PHP >= 8.3 (with typical extensions like BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- Composer >= 2.8
- Node.js >= 20 & npm
- MySQL Server >= 8.0

---

## Installation & Setup

Follow these steps to set up and run the project locally:

### 1. Install Dependencies
Run composer to install PHP dependencies:
```bash
composer install
```

Run npm to install frontend and assets compiler packages:
```bash
npm install
```

### 2. Configure Environment Variables
Copy the example environment file:
```bash
cp .env.example .env
```

Open the newly created `.env` file and configure:
- **Database**:
  Set your MySQL credentials:
  ```ini
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=fleetfind
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
  ```
- **Timezone**:
  Optionally adjust the application timezone (default is `Asia/Kolkata`):
  ```ini
  APP_TIMEZONE=Asia/Kolkata
  ```
- **Mailgun**:
  Set up Mailgun credentials if you intend to test email sending:
  ```ini
  MAIL_MAILER=mailgun
  MAILGUN_DOMAIN=your_mailgun_domain
  MAILGUN_SECRET=your_mailgun_secret
  MAILGUN_ENDPOINT=api.mailgun.net
  ```

### 3. Generate Application Key
Generate the Laravel encryption key:
```bash
php artisan key:generate
```

### 4. Run Migrations
Run the migrations to create the database schema:
```bash
php artisan migrate
```

---

## Running the Application

To run the application locally, you need to start both the Laravel server and the Vite asset server.

### Start Laravel Dev Server
Start the local PHP development server:
```bash
php artisan serve
```
By default, the server runs at `http://127.0.0.1:8000`.

### Start Vite Dev Server
Start the asset bundling development server (with hot reload support for SCSS/JS changes):
```bash
npm run dev
```

---

## Assets Compilation

To compile assets for production:
```bash
npm run build
```

---

## Running Tests

Run the PHPUnit test suite to ensure everything is functioning correctly:
```bash
php artisan test
```
