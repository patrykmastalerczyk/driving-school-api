# PHP Task - Driving School Application

Simple PHP application for managing driving lessons schedule.

## Quick Start

### Run with Docker

```bash
# Start the application
docker-compose up -d
```

### Access the application

- **Application**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081 (optional)

### Stop the application

```bash
docker-compose down
```

## Features

- Add new driving lessons
- View lessons list
- Delete lessons
- Data validation
- Responsive interface

## API Endpoints

- `GET ?action=get` - Get lessons list
- `POST ?action=add` - Add new lesson
- `DELETE ?action=delete&id=X` - Delete lesson