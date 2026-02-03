# Task & To-Do Management System

A PHP-based task and to-do management system with user authentication, task creation, and to-do tracking capabilities.

## Features

- User authentication (registration, login, logout)
- Password hashing with bcrypt
- Create, read, update, and delete tasks
- Create, read, update, and delete to-do items within tasks
- Mark to-do items as completed/incomplete
- CSRF protection on all forms
- Session-based authentication
- Input validation (frontend and backend)
- Security best practices implemented

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache with mod_rewrite or similar)

## Installation

1. **Clone or download the project files**

2. **Create a MySQL database:**
   ```sql
   CREATE DATABASE todo_management;
   ```

3. **Import the database schema:**
   ```bash
   mysql -u root -p todo_management < database.sql
   ```

4. **Configure database connection:**
   Edit `config/db.php` and set your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'todo_management');
   ```

5. **Set up web server:**
   - Point your web server to the `public/` directory
   - For Apache, ensure `.htaccess` support is enabled (mod_rewrite)
   - Access the application at `http://localhost/public/index.php`

## Project Structure

```
project/
├── config/              # Configuration files
│   └── db.php          # Database connection
├── models/             # Data models
│   ├── User.php        # User model
│   ├── Task.php        # Task model
│   └── Todo.php        # Todo model
├── controllers/        # Controller classes
│   ├── AuthController.php   # Authentication logic
│   ├── TaskController.php   # Task management logic
│   └── TodoController.php   # Todo management logic
├── views/              # HTML templates
│   ├── layout.php      # Main layout template
│   ├── register.php    # Registration page
│   ├── login.php       # Login page
│   ├── tasks.php       # Tasks list page
│   ├── create-task.php # Create task form
│   ├── task-detail.php # Task detail with todos
│   ├── edit-task.php   # Edit task form
│   └── edit-todo.php   # Edit todo item form
├── public/             # Public web directory
│   ├── index.php       # Main application entry point
│   └── css/
│       └── style.css   # Stylesheet
├── includes/           # Helper classes and functions
│   ├── Session.php     # Session management
│   ├── Validator.php   # Input validation
│   └── functions.php   # Utility functions
├── database.sql        # Database schema
└── README.md          # This file
```

## Database Schema

### Users Table
- `id` - Primary key (auto-increment)
- `username` - Unique username (varchar)
- `email` - Unique email (varchar)
- `password_hash` - Bcrypt hashed password (varchar)
- `created_at` - Registration timestamp

### Tasks Table
- `id` - Primary key (auto-increment)
- `user_id` - Foreign key to users table (cascade delete)
- `title` - Task title (varchar)
- `description` - Task description (text)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Todos Table
- `id` - Primary key (auto-increment)
- `task_id` - Foreign key to tasks table (cascade delete)
- `text` - Todo item text (varchar)
- `is_completed` - Completion status (boolean)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## Usage

1. **Register a new account:**
   - Navigate to the application
   - Click "Register" and fill in your details
   - Create your account

2. **Login:**
   - Enter your email and password
   - Click "Login"

3. **Create a task:**
   - Click "+ New Task"
   - Enter task title and description (optional)
   - Click "Create Task"

4. **Add to-do items:**
   - Click "View" on a task
   - Enter a to-do item in the input field
   - Click "Add"

5. **Manage to-do items:**
   - Mark as complete/incomplete using the toggle button
   - Edit to-do text using the "Edit" button
   - Delete to-do items using the "Delete" button

6. **Manage tasks:**
   - Edit task details using the "Edit Task" button
   - Delete entire tasks (including all to-do items) using "Delete Task"

## Security Features

- **Password Hashing:** All passwords are hashed using bcrypt
- **CSRF Protection:** CSRF tokens on all forms
- **Input Validation:** Frontend and backend validation
- **HTML Escaping:** All user input is escaped to prevent XSS attacks
- **Prepared Statements:** All database queries use prepared statements to prevent SQL injection
- **Session Authentication:** Session-based authentication with user ID validation
- **Authorization Checks:** Users can only access and modify their own data

## Validation Rules

- **Username:** 3+ characters, alphanumeric with hyphens and underscores
- **Email:** Valid email format
- **Password:** Minimum 6 characters
- **Task Title:** Required, max 255 characters
- **Todo Text:** Required, max 500 characters

## Error Handling

The application includes error handling for:
- Database connection failures
- Invalid user credentials
- Task/todo not found errors
- Validation errors
- CSRF token errors
- Unauthorized access attempts

## Development Notes

- The application uses an MVC-style architecture
- All database operations use prepared statements for security
- Session data is used for maintaining user authentication
- CSRF tokens are generated and verified on all state-changing operations
- Input is validated on both frontend and backend
- All user output is escaped to prevent XSS attacks

## Troubleshooting

**Cannot connect to database:**
- Verify database credentials in `config/db.php`
- Ensure MySQL is running
- Check database exists: `SHOW DATABASES;`

**Can't create tasks:**
- Verify you are logged in
- Check database tables exist: `SHOW TABLES;`
- Check web server has write permissions if storing files

**Session expires too quickly:**
- Adjust PHP `session.gc_maxlifetime` setting in php.ini
- Default is usually 1440 seconds (24 minutes)

## License

This project is created for educational purposes as part of an internship assessment.

## Support

For issues or questions, please review the code comments or check the database schema in `database.sql`.
