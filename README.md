# Booking System API

A simple **API-only booking system** built with **Laravel 11**, **Sanctum authentication**, and **Scribe documentation**. The API is versioned (`v1`) and provides endpoints to manage resources and bookings.

---

## Features

- **Resource management** – List resources, check availability
- **Booking management** – Create, view, update, and cancel bookings
- **API authentication** – Secured with Laravel Sanctum tokens
- **Versioned API** – All endpoints under `/api/v1`
- **Interactive docs** – Generated with [Scribe](https://scribe.knuckles.wtf/) at `/docs`
- **Helper command** – Easily create API clients with tokens

---

## Requirements

- PHP >= 8.2
- Composer
- Laravel 11
- Database (MySQL, SQLite, Postgres, etc.)

---

## Installation

1. **Clone the repository**

```bash
git clone <repo-url>
cd <repo-folder>
```

2. **Install dependencies**

```bash
composer install
```

3. **Copy environment file and generate app key**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure `.env`**

Set database credentials and other environment variables:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_system
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run migrations**

```bash
php artisan migrate
```

---

## Authentication

This API uses Sanctum for token-based authentication.

### Create an API Client

Use the provided helper command to generate a client with a token:

```bash
php artisan api-client:create {name} {email} --password=optional
```

- If no password is provided, a random one will be generated
- The command outputs the client ID, email, password, and token
- Use the token in the `Authorization` header:

```http
Authorization: Bearer <token>
```

---

## API Endpoints

All endpoints are versioned under `/api/v1` and protected by Sanctum.

### Resources

- `GET /api/v1/resources` – List all resources
- `GET /api/v1/resources/{id}/availability` – Check availability and bookings for a resource

### Bookings

- `POST /api/v1/bookings` – Create a booking
- `GET /api/v1/bookings/{id}` – Get booking details
- `PUT /api/v1/bookings/{id}` – Update a booking
- `DELETE /api/v1/bookings/{id}` – Cancel a booking

Full documentation with examples is available at `/docs` (generated via Scribe).

---

## Generating API Documentation

After annotating your controllers, generate docs using:

```bash
php artisan scribe:generate
```

Docs will be available at:

```
http://your-app.test/docs
```

---

## Running Locally

```bash
php artisan serve
```

Optional: run queues if using async jobs:

```bash
php artisan queue:work
```

---

## Quick Example: Create a Booking via curl

```bash
curl -X POST http://localhost:8000/api/v1/bookings \
-H "Authorization: Bearer <YOUR_TOKEN>" \
-H "Content-Type: application/json" \
-d '{
  "resource_id": 1,
  "start_time": "2025-09-18T10:00:00",
  "end_time": "2025-09-18T12:00:00",
  "customer_info": "John Doe"
}'
```

---

## License

This project is licensed under MIT.
