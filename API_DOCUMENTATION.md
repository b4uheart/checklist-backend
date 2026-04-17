# Checklist API Documentation

## Base URL

Use your app base URL, for example:

```text
http://localhost/checklist
```

All API endpoints below are relative to that base URL.

## Stack

- Backend: CodeIgniter 3
- Auth: JWT Bearer token
- Response format: JSON

## Authentication

Most API endpoints require a bearer token.

Send this header after login:

```http
Authorization: Bearer YOUR_JWT_TOKEN
```

## Standard Success Pattern

Most endpoints return one of these shapes:

```json
{
  "success": true,
  "data": {}
}
```

or

```json
{
  "success": true,
  "token": "...",
  "user": {}
}
```

## Standard Error Pattern

```json
{
  "success": false,
  "error": "Human readable message",
  "code": "MACHINE_READABLE_CODE"
}
```

## Endpoint List

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| POST | `/api/login` | No | Login and get JWT token |
| GET | `/api/auth/me` | Yes | Get current logged-in user |
| POST | `/api/auth/logout` | Yes | Logout response for client flow |
| GET | `/api/equipment/qr/{qr_code}` | Yes | Get equipment by QR code |
| GET | `/api/questions/{equipment_id}` | Yes | Get checklist questions by equipment |
| POST | `/api/inspections/save` | Yes | Save inspection with responses |
| GET | `/api/dashboard/summary` | Yes | Get dashboard summary stats |
| GET | `/api/dashboard/recent-scans` | Yes | Get recent inspections/scans |
| GET | `/api/inspections/history` | Yes | Get inspection history list |
| GET | `/api/inspections/{id}` | Yes | Get inspection detail |

---

## 1. Login

### Endpoint

```http
POST /api/login
```

### Request Body

```json
{
  "email": "admin",
  "password": "Welcome123"
}
```

Notes:
- `email` can be either actual email or username.
- The backend checks both `users.username` and `users.email`.

### cURL Example

```bash
curl -X POST http://localhost/checklist/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin","password":"Welcome123"}'
```

### Success Response

```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com"
  }
}
```

### Error Responses

`400 Bad Request`

```json
{
  "success": false,
  "error": "Email and password required"
}
```

`401 Unauthorized`

```json
{
  "success": false,
  "error": "Invalid credentials"
}
```

---

## 2. Get Current User

### Endpoint

```http
GET /api/auth/me
```

### Headers

```http
Authorization: Bearer YOUR_JWT_TOKEN
```

### Success Response

```json
{
  "success": true,
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com",
    "role": "admin"
  }
}
```

### Error Response

`404 Not Found`

```json
{
  "success": false,
  "error": "User not found",
  "code": "USER_NOT_FOUND"
}
```

---

## 3. Logout

### Endpoint

```http
POST /api/auth/logout
```

### Headers

```http
Authorization: Bearer YOUR_JWT_TOKEN
```

### Success Response

```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

Note:
- This is currently a client-flow logout response.
- It does not revoke JWT tokens in database storage because tokens are stateless right now.

---

## 4. Get Equipment By QR Code

### Endpoint

```http
GET /api/equipment/qr/{qr_code}
```

### Example

```http
GET /api/equipment/qr/QR-ABC123
Authorization: Bearer YOUR_JWT_TOKEN
```

### Success Response

```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "HVAC Unit A",
    "qr_code": "QR-ABC123",
    "status": "active",
    "model": "HVX-5000",
    "location": "Building 3",
    "manufacturer": "CoolTech",
    "last_maintenance_date": "2026-04-10",
    "next_maintenance_date": "2026-05-10",
    "created_at": "2026-04-17 12:10:00"
  }
}
```

### Error Response

`404 Not Found`

```json
{
  "success": false,
  "error": "Equipment not found",
  "code": "EQUIPMENT_NOT_FOUND"
}
```

---

## 5. Get Checklist Questions

### Endpoint

```http
GET /api/questions/{equipment_id}
```

### Example

```http
GET /api/questions/1
Authorization: Bearer YOUR_JWT_TOKEN
```

### Success Response

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "equipment_id": 1,
      "question": "Check refrigerant levels",
      "is_mandatory": 1,
      "type": "boolean",
      "order_index": 1,
      "category": "Cooling",
      "help_text": null,
      "remark_required_on_non_comply": 1,
      "created_at": "2026-04-17 12:15:00"
    }
  ]
}
```

Notes:
- Questions are ordered by `order_index`, then `id`.

---

## 6. Save Inspection

### Endpoint

```http
POST /api/inspections/save
```

### Headers

```http
Content-Type: application/json
Authorization: Bearer YOUR_JWT_TOKEN
```

### Request Body

```json
{
  "equipment_id": 1,
  "responses": [
    {
      "question_id": 1,
      "response": "comply",
      "remark": "All good",
      "image_url": "uploads/photo1.jpg"
    },
    {
      "question_id": 2,
      "response": "non-comply",
      "remark": "Needs service",
      "image_url": ""
    }
  ]
}
```

### Success Response

```json
{
  "success": true,
  "inspection_id": 15,
  "saved_responses": 2
}
```

### Error Responses

`400 Bad Request`

```json
{
  "success": false,
  "error": "Invalid input. Require equipment_id and responses array.",
  "code": "VALIDATION_ERROR"
}
```

`404 Not Found`

```json
{
  "success": false,
  "error": "Equipment not found",
  "code": "EQUIPMENT_NOT_FOUND"
}
```

---

## 7. Dashboard Summary

### Endpoint

```http
GET /api/dashboard/summary
```

### Headers

```http
Authorization: Bearer YOUR_JWT_TOKEN
```

### Success Response

```json
{
  "success": true,
  "data": {
    "total_equipment": 24,
    "completed_today": 8,
    "pending_count": 3,
    "compliance_rate": 94
  }
}
```

---

## 8. Dashboard Recent Scans

### Endpoint

```http
GET /api/dashboard/recent-scans?limit=10
```

### Headers

```http
Authorization: Bearer YOUR_JWT_TOKEN
```

### Success Response

```json
{
  "success": true,
  "data": [
    {
      "equipment_id": 1,
      "equipment_name": "HVAC Unit A",
      "qr_code": "QR-ABC123",
      "inspection_id": 15,
      "status": "completed",
      "scanned_at": "2026-04-17T09:42:00+00:00",
      "time_ago": "2 min ago"
    }
  ]
}
```

### Query Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `limit` | int | No | Number of recent rows to return. Default `10` |

---

## 9. Inspection History

### Endpoint

```http
GET /api/inspections/history
```

### Headers

```http
Authorization: Bearer YOUR_JWT_TOKEN
```

### Supported Query Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `page` | int | No | Page number. Default `1` |
| `limit` | int | No | Page size. Default `20` |
| `equipment_id` | int | No | Filter by equipment |
| `date_from` | date | No | Filter from date `YYYY-MM-DD` |
| `date_to` | date | No | Filter to date `YYYY-MM-DD` |
| `status` | string | No | Filter by inspection status |

### Example

```http
GET /api/inspections/history?page=1&limit=20&status=completed
Authorization: Bearer YOUR_JWT_TOKEN
```

### Success Response

```json
{
  "success": true,
  "data": [
    {
      "inspection_id": 15,
      "equipment_id": 1,
      "equipment_name": "HVAC Unit A",
      "qr_code": "QR-ABC123",
      "completed_at": "2026-04-17T09:42:00+00:00",
      "answered_count": 10,
      "total_questions": 10,
      "progress": 1,
      "status": "completed"
    }
  ],
  "meta": {
    "page": 1,
    "limit": 20,
    "total": 124
  }
}
```

---

## 10. Inspection Detail

### Endpoint

```http
GET /api/inspections/{id}
```

### Headers

```http
Authorization: Bearer YOUR_JWT_TOKEN
```

### Example

```http
GET /api/inspections/15
Authorization: Bearer YOUR_JWT_TOKEN
```

### Success Response

```json
{
  "success": true,
  "data": {
    "inspection_id": 15,
    "equipment": {
      "id": 1,
      "name": "HVAC Unit A",
      "qr_code": "QR-ABC123"
    },
    "completed_at": "2026-04-17T09:42:00+00:00",
    "inspector": {
      "id": 1,
      "name": "Admin",
      "email": "admin@example.com"
    },
    "responses": [
      {
        "question_id": 1,
        "question": "Check refrigerant levels",
        "response": "comply",
        "remark": "All good",
        "image_url": "uploads/photo1.jpg"
      }
    ]
  }
}
```

### Error Response

`404 Not Found`

```json
{
  "success": false,
  "error": "Inspection not found",
  "code": "INSPECTION_NOT_FOUND"
}
```

---

## Common Error Responses

### Unauthorized

```json
{
  "success": false,
  "error": "Unauthorized. Valid Bearer token required.",
  "code": "AUTH_UNAUTHORIZED"
}
```

### Equipment Not Found

```json
{
  "success": false,
  "error": "Equipment not found",
  "code": "EQUIPMENT_NOT_FOUND"
}
```

### Validation Error

```json
{
  "success": false,
  "error": "Invalid input. Require equipment_id and responses array.",
  "code": "VALIDATION_ERROR"
}
```

---

## Suggested API Usage Flow

### Mobile/Web Login Flow

1. Call `POST /api/login`
2. Save returned JWT token
3. Call `GET /api/auth/me` to validate token and load user profile

### Inspection Flow

1. Scan QR code
2. Call `GET /api/equipment/qr/{qr_code}`
3. Read `equipment.id`
4. Call `GET /api/questions/{equipment_id}`
5. Submit answers with `POST /api/inspections/save`
6. Show history using `GET /api/inspections/history`

### Dashboard Flow

1. Call `GET /api/dashboard/summary`
2. Call `GET /api/dashboard/recent-scans`

---

## Notes

- All IDs are integer IDs.
- Inspection IDs are now auto-increment integers, not UUID strings.
- Login currently uses JWT without database token persistence.
- `POST /api/auth/logout` returns success for client logout flow, but does not revoke JWT server-side.
- If you use Apache, make sure the `Authorization` header is forwarded properly in `.htaccess` if needed.
