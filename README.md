# Laravel API Health Check

A robust, Dockerized Laravel API demonstrating health check monitoring, rate limiting, and request logging. Built as a test assignment for a Back-end Developer position.

## Quick Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/PavelMister/health-check-service .
   ```
2. Start the infrastructure:
   ```bash
   docker compose up -d --build
   ```
   *(Note: The container's `entrypoint.sh` will automatically generate the `.env` file, install Composer dependencies, wait for MySQL to initialize, and run all database migrations).*

## Features & Architecture

- **API Versioning**: Endpoints are properly scoped under `/api/v1/` for future scalability.
- **Health Check**: Validates MySQL and Redis connections using Dependency Injection. Returns HTTP 500 with a JSON payload if any service is down.
- **Resilience**: Implemented a Global Exception Handler for `RedisException`. If the Redis service crashes, the application gracefully returns a 500 JSON response instead of a fatal framework error.
- **Security**: Mandatory `X-Owner` header validation ensuring the provided value is a valid UUID format.
- **Rate Limiting**: Throttled to 60 requests/minute per `X-Owner` UUID, utilizing Redis as the cache store.
- **Logging**: Every API request is logged to the `log_api_requests` database table via a dedicated Middleware. System errors are logged via standard Laravel Logger channels.
- **Code Quality**: Enforced strict typing (`declare(strict_types=1);`) and utilized Dependency Injection across Controllers and Middleware.

## 🧪 Testing

### Automated Tests (PHPUnit)
Run the feature tests inside the application container to verify the core logic:
```bash
docker compose exec app php artisan test
```

### Manual Testing
- **Success Request**:
  ```bash
  curl -H "X-Owner: 550e8400-e29b-41d4-a716-446655440000" http://localhost:8000/api/v1/health-check
  ```
- **Failover Test (Redis down)**:
  ```bash
  docker compose stop redis
  # Send the curl request again -> Observe a graceful 500 JSON response with "cache": false.
  ```
- **Throttle Test**: Send 61+ requests within a minute using Postman Runner to observe the `429 Too Many Requests` response.

## 🛡️ Security Considerations & Future Improvements

In the context of this assignment, the rate limiter is bound directly to the `X-Owner` header. Since the system currently accepts any structurally valid UUID, it is theoretically vulnerable to rate-limit bypassing if a malicious client generates a new UUID for every request.

**For a production-ready environment, I would implement:**
1. **Database Validation**: Verify that the `X-Owner` UUID actually exists in an `api_keys` or `users` table (authorization) before allowing the request to hit the rate limiter.
2. **Fallback IP Limiting**: Add a secondary, broader rate limit based on `$request->ip()` to prevent DDoS attacks and session fraud from a single source rotating fake UUIDs.
