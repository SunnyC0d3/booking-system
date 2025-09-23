# Booking System API

A **production-ready booking system** built with **Laravel 11**, **Sanctum authentication**, and **automated availability management**. The API is versioned (`v1`) and provides comprehensive endpoints to manage resources, availability, and bookings at scale.

**🆕 NEW:** Now includes a **Smart Enquiry System** with **Microsoft 365 Calendar Integration** for seamless enquiry-to-calendar workflow!

---

## Features

### Core Booking System
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

### 🆕 Smart Enquiry System
- **Simplified customer experience** – No availability constraints, just date selection
- **Smart email notifications** – Professional emails with one-click action buttons
- **Microsoft 365 integration** – Seamless calendar sync with Outlook/Office 365
- **Bidirectional sync** – Calendar changes automatically update enquiry status
- **Owner-friendly workflow** – Everything managed through familiar calendar interface
- **Real-time webhooks** – Instant synchronization with Microsoft Graph API
- **Automated customer communication** – Approval/decline emails sent automatically
- **Comprehensive audit trail** – Full history of all enquiry interactions

---

## Requirements

- PHP >= 8.2
- Composer
- Laravel 11
- Database (MySQL, SQLite, Postgres, etc.)
- **Microsoft 365 Business Account** (for enquiry system)
- **Azure App Registration** (for calendar integration)

---

## Installation

1. **Clone the repository**

```bash
git clone 
cd 
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

4. **Configure database in `.env`**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_system
DB_USERNAME=root
DB_PASSWORD=
```

5. **🆕 Configure Microsoft 365 integration (optional)**

Add these variables to your `.env` file:

```env
# Microsoft 365 Integration
MICROSOFT_CLIENT_ID=your_azure_app_client_id
MICROSOFT_CLIENT_SECRET=your_azure_app_client_secret
MICROSOFT_REDIRECT_URI=https://yourapp.com/api/v1/auth/microsoft/callback
MICROSOFT_TENANT_ID=common
MICROSOFT_WEBHOOK_SECRET=your_random_webhook_secret

# Enquiry System Settings
ENQUIRY_BUSINESS_NAME="Your Business Name"
ENQUIRY_OWNER_EMAIL=owner@yourbusiness.com
ENQUIRY_FROM_EMAIL=noreply@yourbusiness.com
ENQUIRY_BUSINESS_PHONE="+1-234-567-8900"
```

6. **Run migrations and seed data**

```bash
php artisan migrate
php artisan db:seed
```

7. **Generate initial availability slots**

```bash
# Generate slots for next 30 days
php artisan availability:generate --days=30

# Or generate for entire year
php artisan availability:generate --year=2025
```

---

## 🆕 Microsoft 365 Setup

### Azure App Registration

1. Go to [Azure Portal](https://portal.azure.com) → App registrations
2. Create a new registration with these settings:
    - **Name:** Your Booking System
    - **Redirect URI:** `https://yourapp.com/api/v1/auth/microsoft/callback`
3. Note down the **Client ID** and create a **Client Secret**
4. Add these API permissions:
    - `Calendars.ReadWrite`
    - `offline_access`

### Calendar Authentication Setup

```bash
# Test Microsoft connection
php artisan enquiry:test-microsoft

# Get OAuth URL for authentication
php artisan tinker
>>> app(\App\Http\Controllers\Api\V1\CalendarAuthController::class)->getAuthUrl(new \Illuminate\Http\Request(['user_identifier' => 'owner@business.com']));
```

---

## API Endpoints

All endpoints are versioned under `/api/v1` and protected by Sanctum.

### Core Booking System

**Resources:**
- `GET /api/v1/resources` – List all resources
- `GET /api/v1/resources/{id}/availability` – Get availability with flexible date queries

**Bookings:**
- `POST /api/v1/bookings` – Create a booking
- `GET /api/v1/bookings/{id}` – Get booking details
- `PUT /api/v1/bookings/{id}` – Update a booking
- `DELETE /api/v1/bookings/{id}` – Cancel a booking

### 🆕 Enquiry System

**Enquiries:**
- `POST /api/v1/enquiries` – Submit a new enquiry (public endpoint)
- `GET /api/v1/enquiries` – List enquiries (authenticated)
- `GET /api/v1/enquiries/{id}` – Get enquiry details
- `PUT /api/v1/enquiries/{id}` – Update enquiry
- `DELETE /api/v1/enquiries/{id}` – Cancel enquiry

**Enquiry Actions:**
- `POST /api/v1/enquiries/{id}/approve` – Approve enquiry
- `POST /api/v1/enquiries/{id}/decline` – Decline enquiry
- `GET /api/v1/enquiries/actions/{token}/{action}` – Handle email action links

**Calendar Integration:**
- `GET /api/v1/auth/microsoft/url` – Get OAuth authorization URL
- `GET /api/v1/auth/microsoft/callback` – Handle OAuth callback
- `GET /api/v1/auth/microsoft/status` – Check authentication status
- `POST /api/v1/webhooks/microsoft` – Microsoft webhook endpoint

**Statistics & Management:**
- `GET /api/v1/enquiries/statistics` – Get enquiry analytics
- `GET /api/v1/enquiries/search` – Search enquiries

---

## Usage Examples

### Submit an Enquiry (Public)

```bash
curl -X POST http://localhost:8000/api/v1/enquiries \
-H "Content-Type: application/json" \
-d '{
  "resource_id": 1,
  "preferred_date": "2025-09-25",
  "preferred_start_time": "10:00",
  "preferred_end_time": "12:00",
  "customer_info": {
    "name": "Jane Doe",
    "email": "jane@example.com",
    "phone": "+1234567890",
    "company": "Acme Corp"
  },
  "message": "Looking for decoration services for corporate event"
}'
```

### Create a Traditional Booking

```bash
curl -X POST http://localhost:8000/api/v1/bookings \
-H "Authorization: Bearer " \
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

## 🆕 Management Commands

### Enquiry System Commands

```bash
# Sync enquiries with calendar
php artisan enquiry:sync-calendar --type=pending

# Retry failed synchronizations
php artisan enquiry:sync-calendar --type=retry

# Perform full maintenance
php artisan enquiry:sync-calendar --type=maintenance

# Clean up expired enquiries
php artisan enquiry:cleanup --dry-run

# Test Microsoft 365 connection
php artisan enquiry:test-microsoft
```

### Existing Booking Commands

```bash
# Generate availability slots
php artisan availability:generate --days=90

# Clean up old slots
php artisan availability:cleanup --days=30
```

---

## Configuration

### Booking System Configuration

Customize booking behavior in `config/booking.php`:

```php
return [
    'default_slot_duration' => 60,
    'max_advance_booking_days' => 365,
    'min_advance_booking_hours' => 2,
    // ...
];
```

### 🆕 Enquiry System Configuration

Configure the enquiry system in `config/enquiry.php`:

```php
return [
    'business_name' => env('ENQUIRY_BUSINESS_NAME'),
    'owner_email' => env('ENQUIRY_OWNER_EMAIL'),
    'default_expiry_days' => 30,
    'add_customer_as_attendee' => false,
    // ...
];
```

### 🆕 Microsoft 365 Configuration

Configure calendar integration in `config/microsoft.php`:

```php
return [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'scopes' => [
        'https://graph.microsoft.com/Calendars.ReadWrite',
        'https://graph.microsoft.com/offline_access',
    ],
    // ...
];
```

---

## 🆕 Email Templates

The enquiry system includes professional email templates:

- **Enquiry Notification** – Sent to business owner with action buttons
- **Customer Confirmation** – Acknowledges enquiry submission
- **Approval Email** – Confirms booking with calendar links
- **Decline Email** – Politely explains why request can't be accommodated
- **Sync Error Email** – Alerts administrators to technical issues

All templates are mobile-responsive and include calendar integration buttons.

---

## System Architecture

### Dual Workflow Support

**Traditional Booking System:**
- Availability-constrained bookings
- Real-time conflict prevention
- Immediate confirmation
- Perfect for time-sensitive resources

**🆕 Smart Enquiry System:**
- Owner-approval workflow
- Microsoft 365 calendar integration
- Email-driven actions
- Perfect for service-based businesses

Both systems operate independently and can be used simultaneously.

---

## Production Deployment

1. **Set up environment variables**
2. **Run migrations:** `php artisan migrate --force`
3. **Generate initial availability:** `php artisan availability:generate --year=2025`
4. **🆕 Configure Microsoft 365 integration**
5. **Set up cron job:** `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1`
6. **Configure queue workers** for email processing
7. **🆕 Set up webhook endpoint** for real-time calendar sync

### Queue Configuration

Add to your supervisor configuration:

```ini
[program:booking-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --tries=3
directory=/path/to/project
user=www-data
numprocs=2
```

---

## Monitoring & Maintenance

### Health Checks

```bash
# Check overall system health
php artisan enquiry:test-microsoft

# View sync statistics
php artisan enquiry:sync-calendar --type=maintenance --dry-run

# Check authentication status
curl -H "Authorization: Bearer " \
"http://yourapp.com/api/v1/auth/microsoft/status"
```

### Automated Maintenance

The system includes automated maintenance tasks:

- **Daily:** Sync pending enquiries, renew expiring webhooks
- **Weekly:** Clean up expired enquiries and old sync logs
- **Monthly:** Generate availability slots for next 3 months

---

## Troubleshooting

### Common Issues

**Microsoft Authentication Fails:**
```bash
php artisan enquiry:test-microsoft --user=owner@business.com
```

**Webhooks Not Working:**
- Check `MICROSOFT_WEBHOOK_SECRET` in `.env`
- Verify webhook URL is publicly accessible
- Review webhook subscription status

**Emails Not Sending:**
- Verify mail configuration in `.env`
- Check queue workers are running
- Review failed jobs table

---

## Frontend Integration

### Traditional Booking API

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

### 🆕 Enquiry API

```json
{
  "data": {
    "id": 1,
    "resource": {"id": 1, "name": "Event Decoration"},
    "preferred_date": "2025-09-25",
    "customer_info": {
      "name": "Jane Doe",
      "email": "jane@example.com"
    },
    "status": "pending",
    "calendar_sync": {
      "enabled": true,
      "status": "synced",
      "has_microsoft_event": true
    }
  }
}
```

Perfect for building modern booking interfaces with React, Vue, or any frontend framework.

---

## License

This project is licensed under MIT.
