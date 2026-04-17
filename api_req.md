# API Requirements For Full App Functionality

## Current app status

The app currently has working or partially wired support for these flows:

- Login via `POST /auth/login`
- Fetch equipment by QR via `GET /api/equipment/qr/{qrCode}`
- Fetch checklist questions via `GET /api/questions/{equipmentId}`
- Save inspection answers via `POST /api/inspections/save`

The app still uses hardcoded UI data for major areas like Dashboard and History, so the backend is not yet sufficient to make the full app functional end to end.

## Files reviewed

- `lib/services/api_service.dart`
- `lib/providers/auth_provider.dart`
- `lib/models/equipment.dart`
- `lib/models/question.dart`
- `lib/models/response_item.dart`
- `lib/models/login_response.dart`
- `lib/screens/login_screen.dart`
- `lib/screens/dashboard_screen.dart`
- `lib/screens/scanner_screen.dart`
- `lib/screens/equipment_screen.dart`
- `lib/screens/checklist_screen.dart`
- `lib/screens/history_screen.dart`
- `lib/screens/app_shell.dart`

## Existing API contracts already assumed by the app

### 1. Login

Endpoint:

- `POST /auth/login`

Request body expected by app:

```json
{
  "email": "user@example.com",
  "password": "secret"
}
```

Response shape expected by app:

```json
{
  "success": true,
  "token": "jwt-or-token-string",
  "user": {
    "id": "1",
    "name": "Admin",
    "email": "user@example.com"
  }
}
```

Notes:

- `success` must be boolean.
- `token` is required for authenticated requests.
- `user` is stored locally in shared preferences.

### 2. Get equipment by QR

Endpoint:

- `GET /api/equipment/qr/{qrCode}`

Header expected when logged in:

- `Authorization: Bearer <token>`

Response shape expected by app:

```json
{
  "data": {
    "id": "eq_1",
    "name": "HVAC Unit A",
    "qr_code": "EQ-2841",
    "status": "active"
  }
}
```

Notes:

- The parser currently expects the equipment object inside `data`.
- `status` is used in UI as active or non-active.

### 3. Get checklist questions

Endpoint:

- `GET /api/questions/{equipmentId}`

Response shape expected by app:

```json
{
  "data": [
    {
      "id": "q1",
      "question": "Check refrigerant levels",
      "equipment_id": "eq_1",
      "is_mandatory": 1
    }
  ]
}
```

Notes:

- `is_mandatory` is accepted as `1`, `"1"`, or falsey values.
- `question` text is rendered directly.

### 4. Save inspection

Endpoint:

- `POST /api/inspections/save`

Request body expected by app:

```json
{
  "equipment_id": "eq_1",
  "responses": [
    {
      "question_id": "q1",
      "response": "comply",
      "remark": ""
    },
    {
      "question_id": "q2",
      "response": "non-comply",
      "remark": ""
    }
  ]
}
```

Response shape expected by app:

```json
{
  "success": true,
  "inspection_id": "insp_1001"
}
```

Notes:

- If `success` is false, the app expects an `error` field.
- Current UI does not yet collect remarks, photos, signatures, or timestamps from the user.

## Missing APIs needed to make the full app functional

## A. Dashboard APIs

The dashboard is currently fully static. To make it real, backend support is needed for both summary stats and recent activity.

### Recommended endpoint: dashboard summary

Endpoint:

- `GET /api/dashboard/summary`

Recommended response:

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

Used by:

- Dashboard stat cards

### Recommended endpoint: recent scans / recent inspections

Endpoint:

- `GET /api/dashboard/recent-scans?limit=10`

Recommended response:

```json
{
  "success": true,
  "data": [
    {
      "equipment_id": "eq_1",
      "equipment_name": "HVAC Unit A",
      "qr_code": "EQ-2841",
      "inspection_id": "insp_1001",
      "status": "completed",
      "scanned_at": "2026-04-17T09:42:00Z",
      "time_ago": "2 min ago"
    }
  ]
}
```

Used by:

- Dashboard recent scan list
- Optional "View All" action

## B. History APIs

The history screen is currently fully static. This is the biggest missing area after dashboard.

### Recommended endpoint: inspection history list

Endpoint:

- `GET /api/inspections/history`

Recommended filters:

- `page`
- `limit`
- `equipment_id`
- `date_from`
- `date_to`
- `status`

Recommended response:

```json
{
  "success": true,
  "data": [
    {
      "inspection_id": "insp_1001",
      "equipment_id": "eq_1",
      "equipment_name": "HVAC Unit A",
      "qr_code": "EQ-2841",
      "completed_at": "2026-04-12T14:30:00Z",
      "answered_count": 10,
      "total_questions": 10,
      "progress": 1.0,
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

Used by:

- History cards
- Progress percentage
- Date display
- Item counts

### Recommended endpoint: inspection detail

Endpoint:

- `GET /api/inspections/{inspectionId}`

Recommended response:

```json
{
  "success": true,
  "data": {
    "inspection_id": "insp_1001",
    "equipment": {
      "id": "eq_1",
      "name": "HVAC Unit A",
      "qr_code": "EQ-2841"
    },
    "completed_at": "2026-04-12T14:30:00Z",
    "inspector": {
      "id": "u1",
      "name": "Admin"
    },
    "responses": [
      {
        "question_id": "q1",
        "question": "Check refrigerant levels",
        "response": "comply",
        "remark": ""
      }
    ]
  }
}
```

Used by:

- Future history detail screen
- Audit trail / re-open / export flows

## C. Equipment detail APIs

Right now equipment detail screen shows real top-level identity, but most deeper fields are still hardcoded.

### Recommended improvement: expand equipment response

Current QR lookup response only covers:

- `id`
- `name`
- `qr_code`
- `status`

To support the existing equipment detail UI properly, backend should also provide:

- `model`
- `location`
- `manufacturer`
- `last_maintenance_date`
- `next_maintenance_date`

Recommended response:

```json
{
  "data": {
    "id": "eq_1",
    "name": "HVAC Unit A",
    "qr_code": "EQ-2841",
    "status": "active",
    "model": "HVX-5000",
    "location": "Building 3, Floor 2",
    "manufacturer": "CoolTech Industries",
    "last_maintenance_date": "2026-03-15",
    "next_maintenance_date": "2026-04-20"
  }
}
```

Alternative:

- Keep QR lookup lightweight and add `GET /api/equipment/{id}` for full detail.

## D. Authentication lifecycle APIs

Login exists, but full app auth behavior usually also needs a few more pieces.

### Recommended endpoint: get current user profile

Endpoint:

- `GET /api/auth/me`

Recommended response:

```json
{
  "success": true,
  "user": {
    "id": "u1",
    "name": "Admin",
    "email": "user@example.com",
    "role": "admin"
  }
}
```

Why needed:

- Validate saved token at app startup
- Refresh local user data after app restart
- Support role-based UI later

### Recommended endpoint: logout

Endpoint:

- `POST /api/auth/logout`

Why needed:

- Invalidate server-side token if backend uses session/token revocation
- Cleaner auth lifecycle

### Optional endpoint: refresh token

Endpoint:

- `POST /api/auth/refresh`

Why needed:

- Avoid forced login when token expires
- Better long-running mobile sessions

## E. Checklist enhancements still likely needed

The checklist flow works at a basic level, but a production-ready app usually needs more than yes/no responses.

### Recommended additions to question payload

Current fields:

- `id`
- `question`
- `equipment_id`
- `is_mandatory`

Useful additions:

- `type` such as boolean, text, number, photo
- `order_index`
- `category`
- `help_text`
- `expected_value`
- `remark_required_on_non_comply`

Recommended shape:

```json
{
  "id": "q1",
  "question": "Check refrigerant levels",
  "equipment_id": "eq_1",
  "is_mandatory": 1,
  "type": "boolean",
  "order_index": 1,
  "category": "Cooling",
  "remark_required_on_non_comply": true
}
```

### Recommended additions to save inspection request

If future UI includes richer evidence, backend may need to accept:

- `remarks`
- `captured_at`
- `inspector_id`
- `attachments`
- `geo_location`

## F. Dashboard and history date formatting support

The app currently shows hardcoded human-readable labels like:

- `2 min ago`
- `2026-04-12 at 14:30`

Backend can either:

- Return ISO timestamps only and let app format locally, which is preferred
- Or additionally return `time_ago` helper strings for convenience

Preferred backend response style:

- Always include ISO datetime fields like `created_at`, `completed_at`, `scanned_at`

## G. Error response consistency

To make the app robust, all APIs should return a consistent error structure.

Recommended error shape:

```json
{
  "success": false,
  "error": "Invalid credentials",
  "code": "AUTH_INVALID"
}
```

Why needed:

- `saveInspection` already expects `error`
- Consistent handling will simplify all screens

## H. Pagination and filtering

History and dashboard lists should support pagination early.

Recommended support:

- `page`
- `limit`
- sorting options
- date range filters
- status filters

This is especially useful for:

- inspection history
- recent scans
- future equipment list screen

## I. App-level items still needed outside pure API

These are not backend endpoints, but they are still needed for the app to feel complete:

- Add startup loading state while `AuthProvider` restores token from shared preferences
- Add logout UI somewhere in app shell or dashboard
- Replace hardcoded dashboard data with provider/service-backed data
- Replace hardcoded history list with real API data
- Replace hardcoded equipment detail fields with API-backed values
- Add empty-state UI for dashboard/history/checklist responses
- Add network error and retry states on dashboard/history/equipment screens
- Normalize text encoding issues in a few labels that still show garbled characters in some files

## Minimum backend needed for full usable app

If the goal is "fully functional" with the current screens, the minimum additional APIs needed are:

1. `GET /api/dashboard/summary`
2. `GET /api/dashboard/recent-scans`
3. `GET /api/inspections/history`
4. Either expand `GET /api/equipment/qr/{qrCode}` or add `GET /api/equipment/{id}`
5. `GET /api/auth/me`
6. Optional but recommended: `POST /api/auth/logout`

## Suggested implementation order

1. Finish auth lifecycle: login, token restore validation, current-user endpoint
2. Finish equipment detail response so scanned equipment page is fully dynamic
3. Finish checklist submission and validation rules
4. Add dashboard summary and recent scans APIs
5. Add inspection history list API
6. Add inspection detail API for future drill-down screen

## Quick summary

Right now the app is only partially API-backed.

Already backed by API:

- login
- scan to equipment lookup
- questions fetch
- inspection save

Still missing real backend support:

- dashboard stats
- recent scans
- history list
- history detail
- full equipment detail
- auth validation/logout lifecycle

Once those are added, the current app structure can be turned into a fully working app without major UI redesign.
