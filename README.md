# Real Estate Management System

A full-featured real estate listing platform built with **Laravel 12**, and **MySQL**. Supports three user roles — Admin, Seller, and Buyer — with property CRUD, image galleries, visit requests, favorites, and an approval workflow.

---

## Features

### Role-Based Access

| Role | Capabilities |
|---|---|
| **Admin** | Dashboard with stats, manage users & categories, approve/reject properties, oversee visit requests |
| **Seller** | List properties, upload up to 5 images per property, manage visit requests (approve/reject/complete) |
| **Buyer** | Browse/search properties, request visits, save favorites, manage visit requests |

### Property Listings
- Create, edit, delete properties with title, description, price, area, bedrooms, bathrooms, garage, location
- Categorize (Apartment, Villa, Duplex, House, Office, Plot)
- Upload up to 5 images per property with thumbnail preview and click-to-view gallery
- Search & filter by keyword, city, category, property type, and price range

### Visit Requests
- Buyers can request property visits with date/time and message
- Sellers can approve, reject, or mark visits as completed
- Admins have full oversight

### Favorites / Wishlist
- Buyers can add/remove properties to favorites
- Dedicated favorites dashboard

### Admin Panel
- User management (CRUD)
- Category management (CRUD)
- Property approval workflow with pending/approved/rejected states
- Dashboard with total users, sellers, buyers, properties, visit requests

### RESTful API
- Public endpoints for properties (list, show, filter by city/type, featured)
- Authenticated endpoints for creating, updating, deleting properties

---

## Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | PHP 8.2+, Laravel 12 |
| **Frontend** | Blade templates, Tailwind CSS 3, Alpine.js |
| **Build** | Vite, Laravel Vite Plugin |
| **Database** | MySQL (SQLite also supported) |
| **Testing** | Pest PHP 3 |
| **Auth** | Laravel Breeze (Blade stack) |

---

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL (or SQLite for development)
- XAMPP / WAMP / Laravel Sail (optional)

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/real-estate-management-system.git
cd real-estate-management-system
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install && npm run build
```

### 4. Environment setup

```bash
cp .env.example .env
```

Edit `.env` and configure your database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=real_estate_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate app key

```bash
php artisan key:generate
```

### 6. Run migrations & seed demo data

```bash
php artisan migrate --seed
```

Demo accounts (all with password `password`):

| Email | Role |
|---|---|
| admin@example.com | Admin |
| seller@example.com | Seller |
| buyer@example.com | Buyer |

### 7. Storage link (for images)

```bash
php artisan storage:link
```

### 8. Build assets & start dev server

```bash
npm run dev
php artisan serve
```

Visit **http://127.0.0.1:8000**

---

## Database Schema

| Table | Purpose |
|---|---|
| `users` | User accounts with role (admin/seller/buyer) |
| `property_categories` | Property categories (Apartment, Villa, etc.) |
| `properties` | Core property listings with approval status |
| `property_images` | Multiple images per property |
| `visit_requests` | Buyer visit scheduling with status workflow |
| `favorites` | Buyer wishlist |
| `sessions` | Database session driver |
| `cache` | Database cache driver |
| `jobs` | Queue driver |

---

## Routes Overview

### Public
| URI | Description |
|---|---|
| `/` | Homepage with featured properties |
| `/properties` | Browse all properties |
| `/properties/search` | Search & filter properties |
| `/properties/{id}` | Property detail page |

### API
| Method | URI | Description |
|---|---|---|
| GET | `/api/properties` | List all properties |
| GET | `/api/properties/featured` | Featured properties |
| GET | `/api/properties/city/{city}` | Filter by city |
| GET | `/api/properties/type/{type}` | Filter by type |
| GET | `/api/properties/{id}` | Single property |
| POST | `/api/properties` | Create property |
| PUT | `/api/properties/{id}` | Update property |
| DELETE | `/api/properties/{id}` | Delete property |

### Authenticated
See full route list in `routes/web.php` and `routes/auth.php`.

---

## Testing

```bash
php artisan test
```

Uses **Pest PHP** with `RefreshDatabase` for feature tests.

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminPropertyController.php
│   │   ├── CategoryController.php
│   │   ├── DashboardController.php
│   │   ├── FavoriteController.php
│   │   ├── ProfileController.php
│   │   ├── PropertyController.php
│   │   ├── UserController.php
│   │   ├── VisitRequestController.php
│   │   └── Api/
│   │       └── PropertyApiController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       ├── SellerMiddleware.php
│       └── BuyerMiddleware.php
├── Models/
│   ├── User.php
│   ├── Property.php
│   ├── PropertyImage.php
│   ├── PropertyCategory.php
│   ├── VisitRequest.php
│   └── Favorite.php
database/
├── factories/
├── migrations/
└── seeders/
    └── DatabaseSeeder.php
resources/
└── views/
    ├── admin/
    ├── auth/
    ├── categories/
    ├── components/
    ├── dashboard/
    ├── favorites/
    ├── layouts/
    ├── profile/
    ├── properties/
    ├── users/
    ├── visit-requests/
    └── welcome.blade.php
routes/
├── web.php
├── api.php
├── auth.php
└── console.php
```

---

## Screenshots

*(Add screenshots here)*

---

## License

This project is open-sourced under the MIT license.
// Initial project setup with Laravel 12 - 2026-06-01 00:00:00

