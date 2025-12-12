## Fitness Coaching Management API

Base URL: /api

Authentication: Laravel Sanctum personal access tokens. Include header:
Authorization: Bearer {token}

### Auth
- POST auth/{role}/register
  - roles: admin|coach|client
  - body (admin): {"full_name":"...","email":"...","password":"...","security_question":"...","security_answer":"..."}
  - body (coach extra): + quotes?, security_question?, security_answer?
  - body (client extra): + coach_id, height?, weight?, subscription_type?, status?, security_question?, security_answer?
  - All fields: security_question?, security_answer? (optional, string, max:255)
  - 201: { user, token }

- POST auth/{role}/login
  - body: {"email":"...","password":"..."}
  - 200: { user, token }

- POST auth/logout
  - headers: Bearer token
  - 200: { message }

### Admin-only (auth + role:admin)
- GET admins
- POST admins { full_name, email, password, security_question?, security_answer? }
- GET admins/{id}
- PUT/PATCH admins/{id} { full_name?, email?, password?, security_question?, security_answer? }
- DELETE admins/{id}

- GET coaches
- POST coaches { full_name, email, password, security_question?, security_answer?, quotes? }
- GET coaches/{id}
- PUT/PATCH coaches/{id} { full_name?, email?, password?, security_question?, security_answer?, quotes? }
- DELETE coaches/{id}

- GET clients
- POST clients { coach_id, full_name, email, password, security_question?, security_answer?, height?, weight?, subscription_type?, status? }
- GET clients/{id}  // includes coach, plans, progress, payment
- PUT/PATCH clients/{id} { ...fields optional including security_question?, security_answer?... }
- DELETE clients/{id}

- GET payments
- POST payments { client_id, amount, payment_date, method, status }
- GET payments/{id}
- PUT/PATCH payments/{id} { ...optional fields... }
- DELETE payments/{id}

Example create coach:
POST /api/coaches
{"full_name":"Jane Coach","email":"jane@x.com","password":"secret123","security_question":"What's your favorite color?","security_answer":"Blue","quotes":"Push limits"}

### Coach-only (auth + role:coach)
- GET coach/clients  // list their clients
- CRUD meal-plans
- CRUD session-plans
- CRUD progress-trackers

Example create meal plan:
POST /api/meal-plans
{"client_id": 1, "notes":"High protein","protein":140,"carbs":180,"fats":50}

### Client-only (auth + role:client)
- GET me  // full client details with coach, plans, progress, payment

### Responses and errors
- 200: Success with resource
- 201: Created
- 204: No content
- 401: Unauthenticated
- 403: Forbidden
- 404: Not found
- 422: Validation error

### Setup (SQLite default)
1) cp .env.example .env
2) php artisan key:generate
3) php artisan migrate --seed

To use MySQL: update .env DB_CONNECTION=mysql, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD; then run php artisan migrate --seed.


