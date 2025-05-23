# README.md - Project Setup

## 1. Introduction
This document provides a comprehensive guide for installing, configuring, and running the project. It covers prerequisites, setup instructions, common issues, and troubleshooting steps.

---

## 2. Project Overview
- **Frontend:** Vue.js (Version X.X.X)
- **Backend:** Symfony (Version X.X.X)
- **Architecture:**
    - **Frontend:** Modular Vue.js components with Vue Router and Vuex (if applicable)
    - **Backend:** Hexagonal architecture following Domain-Driven Design (DDD)
    - **Infrastructure:** Dockerized environment with separate services

### Project Structure
```
project-root/
│── backend/             # Symfony backend
│   ├── src/             # Application source code
│   │   ├── Card/        # Card-related logic
│   │   ├── Shared/      # Shared utilities and common logic
│   │   ├── Provider/    # External service providers and integrations
│   │   ├── Auth/        # Authentication and security mechanisms
│   ├── config/          # Configuration files
│   ├── bin/             # Symfony CLI commands
│   ├── tests/           # Backend tests
│   ├── public/          # Public files (entry point for web requests)
│   ├── .env             # Environment variables
│   └── composer.json    # Dependencies
│
│── frontend/            # Vue.js frontend
│   ├── src/             # Vue application source code
│   │   ├── components/  # UI components
│   │   ├── views/       # Page views
│   │   ├── store/       # Vuex store (if used)
│   │   ├── router/      # Vue Router configuration
│   │   ├── services/    # API service handlers
│   │   ├── assets/      # Static assets (images, styles, etc.)
│   ├── public/          # Static files
│   ├── package.json     # Frontend dependencies
│
│── docker/              # Docker configurations
│── Makefile             # Make commands
│── README.md            # Project documentation
```

---

## 3. Prerequisites
Ensure you have the following installed before running the project:

- **Docker** and **Docker Compose**
- **Make** (for executing predefined commands)
- **Git** (if cloning from a repository)
- **Node.js & npm** (for frontend dependencies)
- **Proper system permissions** to run Docker containers

---

## 4. Installation & Setup

### 4.1. Clone the Repository
If using a ZIP archive, extract and navigate to the project directory:
```bash
 unzip project.zip -d project
 cd project
```

### 4.2. Set Up Environment Variables
Ensure the `.env` file exists in the root of both the **backend** and **frontend** directories:
```bash
 cp backend/.env.example backend/.env
 cp frontend/.env.example frontend/.env
```
Edit the environment variables as needed.

### 4.3. Build and Start Containers
To build and start all required services:
```bash
 make up
```
This will initialize the Docker containers.


To rebuild from scratch:
```bash
 make rebuild
```
### 4.4. 🚨Important: Import Credit Cards Data
After starting the backend, you must enter the container and run 
the following command to import credit card data from the external API
```bash
 docker exec -it symfony_app bash
bin/console app:import-cards
```

### 4.5. Verify Running Containers
Check the running containers:
```bash
 docker ps
```
To view logs:
```bash
 docker-compose logs -f
```

---

## 5. Troubleshooting

### 5.1. Permission Issues
If you encounter permission errors, change file ownership:
```bash
 sudo chown -R $USER:$USER .
```
Or grant execution permissions to `make`:
```bash
 chmod +x Makefile
```
If Docker permission issues arise, add your user to the Docker group:
```bash
 sudo usermod -aG docker $USER
```
Then log out and back in.

### 5.2. Containers Not Starting
If containers fail to start, try:
```bash
 make down
 docker system prune -af
 make up
```

### 5.3. Application Not Responding
- Ensure containers are running: `docker ps`
- Check logs for errors: `docker-compose logs -f`
- Confirm the correct port is exposed in `.env`

---

## 6. Stopping the Project
📌To stop running containers:
```bash
 make down
```
To remove volumes and clean up the environment:
```bash
 make clean
```

---
## 8. Testing the Project and PHPCS
✅ Running PHP_CodeSniffer (PHPCS)
To ensure your code follows coding standards, use PHP_CodeSniffer (phpcs).
```bash
vendor/bin/phpcs --standard=PSR12 src/
vendor/bin/phpcbf --standard=PSR12 src/
```
or
```bash
 composer phpcs
 composer phpcbf
 ```
✅ Running PHPUnit Tests

🚨 Remember `ENV=test` must be set in the `.env` file for testing.
To ensure the project functions correctly, run PHPUnit tests.

📌 Run all tests
```bash
 vendor/bin/phpunit
```
or
```bash
 composer test
```
## 9. API Documentation
🚀 Access the API documentation
Once the backend is running, open:
```bash
 http://localhost:8001/api/doc
```
🛠 Customize API documentation
Modify `config/packages/nelmio_api_doc.yaml` to adjust the documentation settings.

## 10. Conclusion
This guide outlines the essential steps to install, configure, and run the project. Following these instructions ensures a smooth development setup. If you encounter further issues, consult Docker, Make, and Vue.js/Symfony documentation.

