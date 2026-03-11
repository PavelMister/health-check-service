# Laravel API Health Check (Test Task)

## Setup
1. `git clone <repo>`
2. `docker compose up -d`

## Features
- **API Versioning**: All routes prefixed with `/api/v1/`.
- **Health Check**: Validates MySQL and Redis connections. Returns 500 if any service is down.
- **Security**: Mandatory `X-Owner` header validation (UUID format).
- **Rate Limiting**: 60 requests/min via Redis throttle.
- **Logging**: Every request is logged to the `log_api_requests` table. Errors are logged via Laravel Logger.

## Testing
- **Success**: `curl -H "X-Owner: <uuid>" http://localhost:8000/api/v1/health-check`
- **Throttle test**: Use Postman Runner (60+ iterations).
- **Failover test**: `docker compose stop redis` -> observe 500 JSON response.
