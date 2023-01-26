# Running WorldCup Strava Webhook

Backend REST API on PHP (8.1) + Laravel(9) + MySQL(8.0).

# Subscription & Webhook API
This API allow subscription and listening to events from Strava.

# Features
- Strava Webhook Subscription
- Strava Webhook Verification
- Strava Activity Management (Create, Update, Delete)

## Quick Start to run locally
- Clone repository
- Run composer install
- copy .env.example file to .env
- Open .env and setup database connection
- Run `composer install`
- Run `php artisan migrate`
- Finally, run `php artisan serve`

## Setting Up Strava Credentials in `.env`
```
STRAVA_CLIENT_ID=
STRAVA_CLIENT_SECRET=
```

## Running Tests

```
php artisan test
```

**Note:** Make sure you set up the test variables in the `.env.testing` file
