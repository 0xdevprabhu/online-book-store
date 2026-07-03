# Online Book Store

A clean, modern, and fully responsive Laravel web application for cataloging and browsing books.

---

## Features

### Client Portal
- **Home & Gallery**: Responsive layouts optimized for mobile, tablet, and desktop viewports.
- **Live Search**: Instant client-side filters for browsing available bookstore records.
- **Live Updates**: Displays a grid of the 4 most recently added books, linking to their respective detail views.

### Admin Panel
- **Protected Session Dashboard**: Secured with a custom middleware to redirect unauthenticated requests.
- **Dashboard Overview**: Displays summary statistic counters (Total Books, In-Stock, Out of Stock, Total Value) and recently added items list.
- **Dual-Mode CRUD Modal**: Single-overlay modal supporting both adding new records and editing existing entries dynamically. Features sticky headers/footers and vertical scrollbars on narrow screens.
- **Google Books Autocomplete API**: Type titles inside the creator modal to fetch details instantly (Title, Author, Description). Supports API key configuration.
- **Resilient Search Fallbacks**: Employs client-side 45s cooldown throttling and fallback lookup searches inside the local database if Google Books returns a `429 (Too Many Requests)` rate-limiting error or goes offline.
- **Responsive Layout**: Hides redundant panels on mobile viewports and displays catalog tables as clean, stacked grid cards. Uses hamburger navigation toggles inside the top header.
- **Custom Delete Overlays**: Replaced native browser alerts with custom modal alerts.

---

## Setup Instructions

### 1. Requirements
Ensure you have PHP 8.2+, Composer, and MySQL (or SQLite) installed.

### 2. Installation Steps
Clone the project, then run:
```bash
composer install
npm install
```

### 3. Environment Configuration
Copy the `.env.example` template to `.env`:
```bash
cp .env.example .env
```
Open `.env` and update your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=online_book_store
DB_USERNAME=root
DB_PASSWORD=
```

*(Optional)* To increase the query quota limit for the Google Books autocomplete lookup, add your Google API key to `.env`:
```env
GOOGLE_BOOKS_API_KEY=your_google_api_key_here
```

### 4. Database Setup & Seeding
Create your local database first:
- **MySQL**: Create an empty database named `online_book_store` in your database manager (e.g. phpMyAdmin, TablePlus).
- **SQLite**: Set `DB_CONNECTION=sqlite` in `.env` and create an empty file inside the project directory:
  ```bash
  touch database/database.sqlite
  ```

Once your database is created, generate the application key, run migrations, and seed default test database records (including the admin credentials):
```bash
php artisan key:generate
php artisan migrate --seed
```

#### Default Admin Login:
- **Email/Username**: `admin@example.com`
- **Password**: `admin123`

### 5. Running the Application
Start the PHP built-in server:
```bash
php artisan serve
```

Access the bookstore at:
- **Storefront:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Admin Panel Login:** [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

---

## Running Tests
Run the Pest testing suite:
```bash
php artisan test
```
