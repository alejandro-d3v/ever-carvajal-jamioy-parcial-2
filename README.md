# PHP + MySQL Docker Project

## Description
This project is a simple PHP application with a MySQL database, containerized using Docker. It demonstrates basic CRUD operations with a users table.

## Project Structure
```
project-root/
├─ app/
│  ├─ Dockerfile
│  ├─ index.php
│  └─ users.php
├─ db/
│  └─ init.sql
├─ docker-compose.yml
├─ .env.example
└─ README.md
```

## How to build and run

2. Build and start the containers:
   ```bash
   docker-compose up -d --build
   ```
3. Verify containers are running:
   ```bash
   docker ps
   ```

## Test the application

- Check welcome page:
  ```bash
  curl http://localhost:8080
  ```

- List users:
  ```bash
  curl http://localhost:8080/users
  ```

- Add a user:
  ```bash
  curl -X POST -H "Content-Type: application/json" -d '{"name":"John","email":"john@example.com"}' http://localhost:8080/users
  ```

## Notes
- The MySQL data is persisted using a Docker volume `db_data`.
- The app connects to the database container via the network alias `db`.
