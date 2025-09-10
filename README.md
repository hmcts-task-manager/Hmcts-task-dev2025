# HMCTS Task Management System

A task management application built for HMCTS caseworkers to help them organise and track daily tasks. Developed in Laravel, it allows creating, viewing, updating, and deleting tasks, managing task statuses, and provides both a web interface and JSON API endpoints.

## Features

**Core Functionality:**
- Complete CRUD operations for task management
- Tasks include title, description, status, and due date
- Task status can be pending, in progress, or done
- Includes input validation and clear error handling
- Responsive layout works on desktop and mobile devices

## Requirements

The following components are required for deployment:
- PHP 8.1 or higher
- Composer dependency manager
- MySQL database server

## Setup

```bash
# Get the code
git clone https://github.com/hmcts-task-manager/Hmcts-task-dev2025.git
cd hmcts-tasks

# Install dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Configure your database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mytasks
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Start the server
php artisan serve
```

The application will be accessible at `http://localhost:8000`.

## Testing

The application includes a comprehensive test suite with both unit and feature tests covering core functionality:

```bash
php artisan test
```

**Test Coverage:**
- Unit tests for model validation and business logic
- Feature tests for API endpoints and user workflows
- Task creation with validation rules
- Task retrieval (individual and collection)
- Status update operations
- Task deletion functionality
- Error handling and edge cases

Tests utilise SQLite in-memory database for optimal performance and isolation from production data.

## API Documentation

The system provides RESTful API endpoints for integration with external systems or headless implementations:

**Get all tasks:**
```http
GET /
Accept: application/json
```

**Response:**
```json
[
  {
    "id": 1,
    "title": "Review case files",
    "description": "Review pending case files for tomorrow's hearing",
    "status": "pending",
    "due_date": "2025-09-03T14:23:00.000000Z",
    "created_at": "2025-09-02T09:17:42.000000Z",
    "updated_at": "2025-09-02T11:34:18.000000Z"
  }
]
```

#### Get Task by ID
```http
GET /tasks/{id}
Accept: application/json
```

#### Create Task
```http
POST /tasks
Content-Type: application/json

{
  "title": "Task title",
  "description": "Optional description",
  "status": "pending",
  "due_date": "2025-09-05 16:45:00"
}
```

**Response:** `201 Created`

#### Update Task Status
```http
PATCH /tasks/{id}/status
Content-Type: application/json

{
  "status": "in_progress"
}
```

#### Update Full Task
```http
PUT /tasks/{id}
Content-Type: application/json

{
  "title": "Updated title",
  "description": "Updated description",
  "status": "done",
  "due_date": "2025-09-07 11:28:00"
}
```

#### Delete Task
```http
DELETE /tasks/{id}
```

**Response:** `200 OK`

### Status Values
- `pending` - Task not started
- `in_progress` - Task currently being worked on
- `done` - Task completed

### Validation Rules
- **title**: Required, max 255 characters
- **description**: Optional
- **status**: Optional, must be one of: pending, in_progress, done
- **due_date**: Optional, must be valid date format

## Database Schema

**Tasks Table**

| Column      | Type                           | Notes                             |
|------------|--------------------------------|-----------------------------------|
| id         | bigint unsigned                | Primary key, auto-increment       |
| title      | varchar(255)                   | Required                          |
| description| text                           | Optional                          |
| status     | enum('pending', 'in_progress', 'done') | Default 'pending'                |
| due_date   | datetime                       | Optional                          |
| created_at | timestamp                      | Set when the task is created      |
| updated_at | timestamp                      | Set when the task is updated      |

The status field tracks task progress and Laravel handles the timestamps automatically.


## Tech Stack

- **Backend**: Laravel 10.x (PHP)
- **Frontend**: Blade templates with Bootstrap 5 (CDN)
- **Database**: MySQL 8.0
- **Testing**: PHPUnit with Laravel testing utilities



