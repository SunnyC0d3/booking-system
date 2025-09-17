# Booking System API

A **production-ready booking system** built with **Laravel 11**, **Sanctum authentication**, and **automated availability management**. The API is versioned (`v1`) and provides comprehensive endpoints to manage resources, availability, and bookings at scale.

---

## Features

- **Resource management** – List resources, check availability with flexible date queries
- **Booking management** – Create, view, update, and cancel bookings with conflict prevention
- **Automated availability** – Generate availability slots for months/years ahead
- **Smart scheduling** – Holiday/blackout date management with recurring rules
- **API authentication** – Secured with Laravel Sanctum tokens
- **Versioned API** – All endpoints under `/api/v1`
- **Calendar integration** – Frontend-ready availability data with date range support
- **Automated maintenance** – Self-managing slot generation and cleanup
- **Interactive docs** – Generated with [Scribe](https://scribe.knuckles.wtf/) at `/docs`
- **Helper commands** – Easy API client creation and availability management

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

5. **Run migrations and seed data**

```bash
php artisan migrate
php artisan db:seed
```

6. **Generate initial availability slots**

```bash
# Generate slots for next 30 days
php artisan availability:generate --days=30

# Or generate for entire year
php artisan availability:generate --year=2025
```

---

## Availability Management

### Automated Slot Generation

Generate bookable time slots automatically:

```bash
# Generate for specific resource and date range
php artisan availability:generate --resource=1 --from=2025-09-18 --to=2025-12-31

# Generate for all resources, next 90 days
php artisan availability:generate --days=90

# Generate entire year for all resources
php artisan availability:generate --year=2025
```

### Cleanup Old Slots

```bash
# Remove slots older than 30 days
php artisan availability:cleanup --days=30

# Preview what would be deleted
php artisan availability:cleanup --dry-run
```

### Automated Scheduling

The system automatically maintains availability slots:

- **Daily at 2 AM** – Generates slots for next 90 days
- **Weekly on Sunday** – Cleans up expired slots
- **December 1st** – Generates next year's availability

Start the scheduler:
```bash
php artisan schedule:work
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
- `GET /api/v1/resources/{id}/availability` – Get availability with flexible date queries

**Availability Query Parameters:**
```bash
# Single date
GET /api/v1/resources/1/availability?date=2025-09-18

# Date range
GET /api/v1/resources/1/availability?from=2025-09-18&to=2025-09-25

# Next N days from today
GET /api/v1/resources/1/availability?days=7
```

### Bookings

- `POST /api/v1/bookings` – Create a booking
- `GET /api/v1/bookings/{id}` – Get booking details
- `PUT /api/v1/bookings/{id}` – Update a booking
- `DELETE /api/v1/bookings/{id}` – Cancel a booking

Full documentation with examples is available at `/docs` (generated via Scribe).

---

## Configuration

Customize booking behavior in `config/booking.php`:

```php
return [
    'default_slot_duration' => 60,              // Minutes per slot
    'max_advance_booking_days' => 365,          // How far ahead users can book
    'min_advance_booking_hours' => 2,           // Minimum notice required
    'generate_slots_for_days_ahead' => 90,      // Auto-generation window
    'generate_weekend_slots' => false,          // Include weekends
    'default_business_hours' => [               // Fallback schedule
        'monday' => ['09:00-17:00'],
        'tuesday' => ['09:00-17:00'],
        // ...
    ],
];
```

---

## Holiday and Blackout Date Management

The system supports global and resource-specific blackout dates:

```bash
# Seed common holidays
php artisan db:seed --class=BlackoutDateSeeder
```

Blackout dates prevent booking on holidays, maintenance days, or other unavailable periods.

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
# Start the application
php artisan serve

# Run the scheduler (for automated maintenance)
php artisan schedule:work

# Optional: run queues if using async jobs
php artisan queue:work
```

---

## API Examples

### Get Resource Availability

```bash
# Get availability for next 7 days
curl -H "Authorization: Bearer <YOUR_TOKEN>" \
"http://localhost:8000/api/v1/resources/1/availability?days=7"

# Get availability for specific date range
curl -H "Authorization: Bearer <YOUR_TOKEN>" \
"http://localhost:8000/api/v1/resources/1/availability?from=2025-09-18&to=2025-09-25"
```

### Create a Booking

```bash
curl -X POST http://localhost:8000/api/v1/bookings \
-H "Authorization: Bearer <YOUR_TOKEN>" \
-H "Content-Type: application/json" \
-d '{
  "resource_id": 1,
  "start_time": "2025-09-18T10:00:00",
  "end_time": "2025-09-18T12:00:00",
  "customer_info": {
    "name": "John Doe",
    "email": "john@example.com"
  }
}'
```

---

## Frontend Integration

The API provides calendar-friendly responses:

```json
{
  "resource": {"id": 1, "name": "Conference Room"},
  "calendar_view": [
    {
      "date": "2025-09-18",
      "available_slots": 5,
      "total_slots": 8,
      "slots": [...]
    }
  ]
}
```

Perfect for building calendar interfaces in React, Vue, or any frontend framework.

---

## Production Deployment

1. **Set up environment variables**
2. **Run migrations:** `php artisan migrate --force`
3. **Generate initial availability:** `php artisan availability:generate --year=2025`
4. **Set up cron job:** `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1`
5. **Configure queue workers** if using background jobs

---

## License

This project is licensed under MIT.
