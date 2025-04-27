# Geomat Test Project

A simple PHP application created as a test assignment for managing products via a REST API.

## Considerations

1. **Security Considerations**
    - **Strict HTTP Methods**: We restrict each endpoint to only the methods it needs (do it in the rounter via custom Route), e.g.:
        - `POST` for creating products
        - `PUT` for updating products
        - `DELETE` for removing products
        - `GET` for fetching products  
          This minimizes the risk of unauthorized or unintended actions.
    - **Authorization**: We recommend token-based authentication (e.g. JWT) to verify user identities, plus role-based access control (RBAC) so that, for instance, only admins can update or delete products.
    - **Rate Limiting**: To prevent abuse (e.g. DoS attacks) and ensure fair usage, implement rate limiting via middleware or a service such as Redis.

2. **API Documentation Generation**
    - **Automatic Documentation Generation**  
      By using Entities and DTOs, you can leverage tools like Swagger-php or OpenAPI annotations to generate interactive docs straight from your code. This keeps docs in sync with your endpoints, request/response models, and data types.
    - **Custom Routing for Documentation**  
      If you need more control, choose a package that supports custom routing to integrate seamlessly with OpenAPI. That lets you centralize routing and documentation maintenance.
    - **Manual OpenAPI Documentation**  
      If automation isn’t an option, you can hand-craft an OpenAPI spec—but remember you’ll need to update it manually whenever your API evolves.

## Technologies Used

- PHP 8.3
- Nette Framework
- PostgreSQL 15
- Docker & Docker Compose
- PHPStan (static code analysis)
- PHP-CS-Fixer (PSR-12 code formatting)

## Requirements

- Docker
- Docker Compose
- Git

## Installation & Running

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/geomat-test-project.git
   cd geomat-test-project
   ```

2. **Create your `.env` file**
   ```bash
   cp .env.local .env
   ```

3. **Start the services**
   ```bash
   docker-compose up -d
   ```

4. **Visit the application**
   ```
   http://localhost:8000
   ```

## Code Analysis & Formatting

### Static Analysis with PHPStan

Run the analyzer to verify code quality:

```bash
docker-compose run --rm phpstan analyse
```

### Automatic Formatting with PHP-CS-Fixer

Install and apply PSR-12 formatting:

```bash
docker-compose exec php vendor/bin/php-cs-fixer fix
```

### Running Tests with PHPUnit

Execute your test suite:

```bash
```docker-compose exec php vendor/bin/phpunit```
```
