# 📅 Event Reminder App

The **Event Reminder App** is a Laravel + Next.js application that allows users to **schedule events, receive reminders via email, and manage event statuses (upcoming/completed).**
It supports **offline event creation & synchronization, CSV import/export, email notifications, and scheduled reminders.**

---

## **🚀 Features**
✅ **CRUD Operations:** Create, Read, Update, Delete event reminders.  
✅ **Auto-Generated Event ID:** Events are assigned a unique ID (e.g., `EVENT-XXXXX`).  
✅ **Email Notifications:** Sends event reminders via email using Laravel Jobs & Queues.  
✅ **Scheduled Reminders:** Automatically dispatches event notifications.  
✅ **Offline Support:** Stores events locally & syncs when online.  
✅ **CSV Import/Export:** Bulk upload & download event data.  
✅ **Pagination & Filtering:** List events efficiently.  
✅ **API-First Approach:** REST API built with Laravel 11.  
✅ **Containerized with Docker:** Easily deploy with Docker & Docker Compose.  
✅ **CI/CD Pipeline:** GitHub Actions for automated builds & Docker Hub integration.

---

## **🛠 Running the App by Building Locally**
```sh
# Clone the repository
git clone https://github.com/Swannhs/event-reminder-app.git

# Change directory
cd event-reminder-app

# Fix environment variables
cd api-service && cp .env.example .env && cd .. && cd ui-service && cp .env.example .env.local && cd ..

# Build & Start Services
docker-compose up --build -d
```

## **🛠 Running the App by Docker Container**
### Quick Start ###
```sh
docker-compose -f docker-compose.dev.yml up -d
```

---

## **🛠️ Tech Stack**
### **Backend (API - Laravel 11)**
- PHP 8.3
- Laravel 11
- MySQL 8.0
- Laravel Queue Worker
- Mailtrap (SMTP Email)
- Swagger (API Documentation) URL: `http://localhost:8000/api/documentation`

### **Frontend (UI - Next.js 14)**
- React + Next.js (App Router)
- TypeScript
- Redux Toolkit (State Management)
- Tailwind CSS
- Axios (API Requests)
- React Hook Form (Form Handling)

### **DevOps & Deployment**
- **Docker & Docker Compose** (Containerized Setup)
- **GitHub Actions** (CI/CD Pipeline)
- **Mailtrap SMTP** (Email Testing)
- **MySQL in Docker** (Database)

---

## **⚙️ API Endpoints (Laravel 11)**
### **📌 Event Management**
| Method | Endpoint                      | Description                |
|--------|-------------------------------|----------------------------|
| GET    | `/api/event-reminders`        | Get all events (paginated) |
| GET    | `/api/event-reminders/{id}`   | Get single event details   |
| POST   | `/api/event-reminders`        | Create a new event         |
| PUT    | `/api/event-reminders/{id}`   | Update an event            |
| DELETE | `/api/event-reminders/{id}`   | Delete an event            |
| POST   | `/api/event-reminders/import` | Import CSV file for events |

---

## **🐳 Docker Setup**
### **Step 1: Build & Start Services**
```sh
docker-compose up --build -d
```

### **Step 2: Run Migrations & Seed Database**
```sh
docker exec -it event_reminder_api php artisan migrate --seed
```

### **Step 3: Start Queue Worker**
```sh
docker exec -it event_reminder_api php artisan queue:work --tries=3 --timeout=90
```

### **Step 4: Open App**
- **API Swagger:** `http://localhost:8000/api/documentation`
- **Frontend:** `http://localhost:3000`

---

## **📧 Email Reminders - Debugging**
### **Step 1: Check `.env` Configuration**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Event Reminder App"
```
### **Step 2: Check Email Queue**
```sh
docker exec -it event_reminder_api php artisan queue:work
```
### **Step 3: Manually Send Reminder**
```sh
docker exec -it event_reminder_api php artisan schedule:send-reminders
```

---

## **📄 License**
This project is open-source under the **MIT License**.

---

## **🚀 Contributors**
👨‍💻 **Developed by:** `Swann`  

