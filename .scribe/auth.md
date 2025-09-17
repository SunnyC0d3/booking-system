# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer Bearer {YOUR_SANCTUM_TOKEN}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Generate a token using: php artisan api-client:create "Your Name" "your.email@example.com"
