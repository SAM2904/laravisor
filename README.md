# Laravisor

Laravisor is a Laravel-native error monitoring package that captures exceptions, sends instant notifications, and optionally stores errors in a central dashboard — without ever breaking your application flow.

It is built with **developer experience first**:
- Works immediately after installation
- No API key required to receive error emails
- Central dashboard is fully optional

---

## Features

- Automatic exception capturing
- Zero-config email notifications
- Environment-based reporting
- Exception ignore list
- Safe, non-blocking execution
- Optional local database storage
- Optional Laravisor Server integration
- Laravel-first design

---

## Requirements

- PHP 8.1+
- Laravel 9.x / 10.x / 11.x
- Mail configuration (for notifications)

---

## Installation

```bash
composer require laravisor/laravisor
```

---

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=laravisor-config
```

This creates:

```bash
config/laravisor.php
```

---

## Quick Start (No Server Required)

Once installed:

- Exceptions are captured automatically
- Error emails are sent instantly
- No API key or dashboard setup required

This is the default behavior.

---

## Configuration Example

```php
return [

    'enabled' => true,

    'environments' => ['production', 'staging', 'local'],

    'notify_emails' => [
        'dev@example.com',
    ],

    'ignore_exceptions' => [
        Illuminate\Auth\AuthenticationException::class,
    ],

    // Optional local storage
    'store_locally' => false,

    // Optional Laravisor Server
    'server' => [
        'enabled' => false,
        'endpoint' => env('LARAVISOR_SERVER_URL'),
        'api_key' => env('LARAVISOR_API_KEY'),
    ],

];
```

---

## Operating Modes

Laravisor adapts automatically based on configuration:

| Mode | API Key | Emails | Storage | Dashboard |
|----|----|----|----|----|
Quick Start | ❌ | ✅ | ❌ | ❌ |
Developer Mode | ❌ | ✅ | Local DB | ❌ |
Full Mode | ✅ | ✅ | Central Server | ✅ |

---

## Local Error Storage (Optional)

Enable storing errors in your application database:

```php
'store_locally' => true,
```

This does not require Laravisor Server or an API key.

---

## Laravisor Server (Optional)

Laravisor Server provides:
- Centralized error storage
- Grouped error viewer
- Error resolution workflow
- Project-based dashboards

Enable via `.env`:

```env
LARAVISOR_SERVER_URL=https://your-server-url
LARAVISOR_API_KEY=your-project-key
```

```php
'server' => [
    'enabled' => true,
],
```

Without a valid key:
- Errors are not stored on the server
- Notifications continue to work normally

---

## Safety Guarantees

Laravisor is designed to **never affect your application**:

- All internal logic is wrapped in try/catch
- Network failures are ignored
- Email failures are ignored
- Safe for queues, schedulers, and cron jobs

---

## License

MIT License © Laravisor