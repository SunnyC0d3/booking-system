# Introduction

Complete API documentation for the Production-Ready Booking System. Manage resources, availability, and bookings with automated slot generation and intelligent conflict prevention.

<aside>
    <strong>Base URL</strong>: <code>http://booking-system.com</code>
</aside>

# Welcome to the Booking System API

This API provides comprehensive booking management with automated availability generation and intelligent conflict prevention.

## Key Features

- **Resource Management**: List and query bookable resources
- **Flexible Availability**: Query availability by date, date range, or days ahead
- **Smart Booking**: Automatic conflict detection and capacity management
- **Holiday Support**: Built-in blackout date system for holidays and maintenance
- **Calendar Integration**: Frontend-ready responses for calendar components

## Getting Started

1. **Authentication**: All endpoints require a Sanctum Bearer token
2. **Generate Token**: Use `php artisan api-client:create` to create API credentials
3. **Base URL**: All endpoints are prefixed with `/api/v1`
4. **Rate Limiting**: 60 requests per minute per token

## Common Patterns

Most endpoints follow RESTful conventions with enhanced query capabilities:

- Single date queries: `?date=2025-09-18`
- Date range queries: `?from=2025-09-18&to=2025-09-25`
- Relative queries: `?days=7` (next 7 days from today)


