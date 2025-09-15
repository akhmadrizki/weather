# Objective

Create a RESTful API using Laravel to demonstrate your proficiency in Laravel API development,
authentication, database design, and adherence to best practices.

## Requirements

1. Setup

-   Implement API authentication using Laravel Sanctum.

2. API Endpoints

Implement the following RESTful API endpoints:

### POSTS

-   GET /api/v1/posts (list all posts)
-   GET /api/v1/posts/{id} (get a specific post)
-   POST /api/v1/posts (create a new post)
-   PATCH /api/v1/posts/{id} (update an existing post)
-   DELETE /api/v1/posts/{id} (delete a post)

### USERS

-   GET /api/v1/users/{id} (get a specific user)
-   POST /api/v1/register (register a new user)
-   POST /api/v1/login (login a user)
-   POST /api/v1/logout (logout a user)

### WEATHER

GET /api/weather (returns current weather data)

3. Database Design

-   Design and implement the necessary database tables using Laravel migrations.
-   Use appropriate relationships between models (e.g., a Post belongs to a User).

4. Features

-   Implement pagination for list endpoints (posts, users).
-   Implement a background job that updates the weather data periodically (e.g., every
    hour).

5. Queue Implementation

-   Implement a queued job for sending a welcome email when a new user registers.
-   Create an artisan command to dispatch this job manually for testing purposes.

6. Validation and Error Handling

-   Implement proper request validation for all endpoints.
-   Use appropriate HTTP status codes and error messages.

7. Testing

-   Write PHPUnit for at least two POSTS and USERS endpoints.
-   Write a test for the weather endpoint, including a mock for the external API calls.

8. External API Integration

-   Connect to a public Weather API (WeatherAPI.com).
-   Retrieve today's weather data for Perth, Australia.
-   Implement an endpoint that returns the current weather data:
    -   GET /api/v1/weather (returns current weather data)
-   Implement appropriate error handling for API failures.
-   Implement caching to store the weather data for a reasonable period (e.g., 15
    minutes) to minimise API calls.

# TNC

Folder structure:

-   make folder per module (example: Controller/User)
-   make validation using form validation
-   use coding standart larastan level max (10)
-   coding format laravel pint
