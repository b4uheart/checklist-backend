# Checklist App API Documentation

## Base URL
```
http://localhost/checklist
```

## Authentication (JWT)
All protected endpoints require header: `Authorization: Bearer <token>`

**Login:** `POST /api/login`
```json
{
  "email": "admin",
  "password": "Welcome123"
}
```
*Note: Uses 'username' field in DB (e.g., 'admin').*

**cURL Example:**
```bash
curl -X POST http://localhost/checklist/api/login \\
  -H "Content-Type: application/json" \\
  -d '{"email":"admin","password":"Welcome123"}'
```

**Response (200):**
```json
{
  "success": true,
  "token": "eyJ...",
  "user": {
    "id": 1,
    "email": "admin"
  }
}
```

**Users table example:**
```sql
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) UNIQUE,
  password VARCHAR(255)
);
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
```

**Errors:**
- 400: Missing email/password
- 401: Invalid credentials

## Protected API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/equipment/qr/{qr_code}` | Get equipment by QR code |
| GET | `/api/questions/{equipment_id}` | Get questions for equipment |
| POST | `/api/inspections/save` | Create inspection + save responses |

## 1. Get Equipment by QR Code
**GET** `/api/equipment/qr/{qr_code}`

**Example:**
```
GET http://localhost/checklist/api/equipment/qr/QR-ABC123
Authorization: Bearer eyJ...
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "id": "4f8a2b1c...",
    "name": "Ladder Model X",
    "qr_code": "QR-ABC123",
    "status": "active"
  }
}
```

**Error (404):**
```json
{"success": false, "error": "Equipment not found"}
```

## 2. Get Questions by Equipment ID
**GET** `/api/questions/{equipment_id}`

**Example:**
```
GET http://localhost/checklist/api/questions/eqp_uuid_here
Authorization: Bearer eyJ...
```

**Success Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": "q1-uuid",
      "question": "Are all rungs secure?",
      "equipment_id": "eqp_uuid",
      "is_mandatory": true
    }
  ]
}
```

## 3. Save Inspection & Responses
**POST** `/api/inspections/save`

**Headers:**
```
Content-Type: application/json
Authorization: Bearer eyJ...
```

**Request:**
```json
{
  "equipment_id": "eqp_uuid",
  "responses": [
    {
      "question_id": "q1-uuid",
      "response": "comply",
      "remark": "All good",
      "image_url": "uploads/photo.jpg"
    }
  ]
}
```

**cURL:**
```bash
curl -X POST http://localhost/checklist/api/inspections/save \\
  -H "Content-Type: application/json" \\
  -H "Authorization: Bearer eyJ..." \\
  -d '{"equipment_id":"eqp_uuid","responses":[{"question_id":"q1","response":"comply"}]}'
```

**Success (200):**
```json
{
  "success": true,
  "inspection_id": "ins-uuid32chars",
  "saved_responses": 2
}
```

**Errors:**
- 400: `{"success":false,"error":"Invalid input. Require equipment_id and responses array."}`
- 401: `{"success":false,"error":"Unauthorized. Valid Bearer token required."}`
- 404: `{"success":false,"error":"Equipment not found"}`

## Error Codes
| Code | Meaning | Example |
|------|---------|---------|
| 200 | Success | - |
| 400 | Bad Request | Invalid input |
| 401 | Unauthorized | Missing/invalid token |
| 404 | Not Found | Equipment missing |

## Testing Flow
1. `POST /api/login` → Get token
2. `GET /api/equipment/qr/QR123` → Get equipment_id
3. `GET /api/questions/{equipment_id}` → Get questions
4. `POST /api/inspections/save` → Submit inspection (UUID id generated)

**APIs ready for mobile/web integration!**

