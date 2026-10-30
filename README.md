# 🎓 UniPlanner

**Your University Life, Organized in One Place.**

UniPlanner is a student productivity and academic planning web application designed to help university students organize academic responsibilities, manage deadlines, plan schedules, and stay on top of university life.

🌐 **Live Application:** http://136.119.215.200

---

## 📌 Table of Contents

- [About the Project](#-about-the-project)
- [Project Goals](#-project-goals)
- [Technology Stack](#-technology-stack)
- [Application Architecture](#-application-architecture)
- [Core Features](#-core-features)
- [Project Structure](#-project-structure)
- [Getting Started](#-getting-started)
- [Environment Configuration](#-environment-configuration)
- [Database](#-database)
- [Security](#-security)
- [Development Workflow](#-development-workflow)
- [Team](#-team)
- [Future Improvements](#-future-improvements)

---

## 🚀 About the Project

University life involves managing multiple responsibilities, including assignments, examinations, lectures, personal tasks, and important deadlines.

Students often rely on several disconnected applications to organize these activities, making it difficult to maintain a clear overview of their academic workload.

**UniPlanner aims to solve this problem** by providing a centralized platform where students can organize their academic activities and manage their time more effectively.

The application is being developed as a collaborative project by a team of four students.

## 🎯 Project Goals

- Organize academic and personal responsibilities.
- Simplify assignment and deadline management.
- Help students plan their time and schedules.
- Provide an overview of upcoming academic activities.
- Track task progress and completion.
- Deliver a responsive and intuitive user experience.
- Store personal planning information reliably.
- Maintain a scalable and maintainable application architecture.

---

## 🛠 Technology Stack

| Technology | Purpose |
|---|---|
| PHP | Backend programming language |
| Laravel | Backend framework and API development |
| Vue.js | Reactive frontend framework |
| Vuetify | UI components and responsive design |
| Vite | Frontend development and build tooling |
| MySQL | Relational database |
| Git | Version control |

### Backend

**Laravel + PHP**

Responsible for:
- Server-side application logic.
- API endpoints and HTTP requests.
- Data validation.
- Authentication and authorization.
- Database communication.
- Application security.

### Frontend

**Vue.js + Vuetify + Vite**

Responsible for:
- Interactive user interfaces.
- Reusable components.
- Responsive page layouts.
- Forms and user interactions.
- Communication with backend services.
- Dynamic application updates.

### Database

**MySQL**

Used for persistent storage of application data, including user accounts and academic planning information according to the finalized database schema.

---

## 🏗 Application Architecture

UniPlanner follows a layered web application architecture.

```text
                 ┌──────────────────────┐
                 │        USER          │
                 └──────────┬───────────┘
                            │
                            ▼
                 ┌──────────────────────┐
                 │     FRONTEND         │
                 │ Vue.js + Vuetify     │
                 │       + Vite         │
                 └──────────┬───────────┘
                            │
                       HTTP Requests
                            │
                            ▼
                 ┌──────────────────────┐
                 │       BACKEND        │
                 │       Laravel        │
                 │                      │
                 │ Controllers          │
                 │ Validation           │
                 │ Business Logic       │
                 │ Authorization        │
                 └──────────┬───────────┘
                            │
                            ▼
                 ┌──────────────────────┐
                 │       DATABASE       │
                 │        MySQL         │
                 └──────────────────────┘
```

### Request Flow

1. The user interacts with the Vue.js frontend.
2. The frontend sends HTTP requests to the Laravel backend.
3. Laravel validates incoming data and checks authorization.
4. The backend processes the request and communicates with MySQL.
5. Laravel returns the appropriate response.
6. Vue.js updates the interface based on the response.

---

## ✨ Core Features

The following modules describe the intended functional scope of UniPlanner. Their final availability depends on the approved MVP scope and implementation progress.

### 👤 User Authentication

- User registration and login.
- Secure password handling.
- User-specific planning information.
- Protected application functionality.
- Access control for personal data.

### 📊 Student Dashboard

A centralized overview of academic responsibilities.

Potential dashboard elements:

- Upcoming deadlines.
- Overdue assignments.
- Upcoming examinations and events.
- Completed and pending tasks.
- Daily schedule overview.
- Quick actions for creating activities.

### ✅ Task Management

Organize assignments, study sessions, and personal responsibilities.

Planned functionality:

- Create, view, edit, and delete tasks.
- Add task descriptions.
- Set deadlines and priorities.
- Track task completion.
- Associate tasks with academic subjects.
- Filter and sort tasks.
- Identify overdue assignments.

### 📅 Calendar and Scheduling

A calendar-based overview of academic activities.

Planned functionality:

- Daily, weekly, and monthly calendar views.
- Create and manage events.
- Schedule examinations and lectures.
- Set event dates and times.
- Organize activities by category.
- Navigate between calendar dates.

### 📚 Subjects and Courses

Organize academic activities by subject.

Potential functionality:

- Create and manage subjects.
- Store subject descriptions.
- Connect tasks and events to subjects.
- Filter activities by subject.
- Use subject labels and colors.

### 🗓 Timetable

A potential module for managing recurring academic activities.

- Weekly timetable.
- Lecture and seminar scheduling.
- Start and end times.
- Classroom and location information.
- Recurring academic activities.

### 🔔 Notifications and Reminders

An optional enhancement for keeping students informed about important academic responsibilities.

Potential functionality:

- Upcoming deadline reminders.
- Event notifications.
- Configurable reminder times.
- Notification history.

---

## 📁 Project Structure

The exact repository structure depends on the current Laravel and Vue.js integration.

A possible organizational structure is:

```text
UniPlanner/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Models/
│   └── ...
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── resources/
│   ├── js/
│   │   ├── components/
│   │   ├── views/
│   │   ├── services/
│   │   └── ...
│   └── ...
│
├── routes/
│   ├── api.php
│   └── web.php
│
├── tests/
├── public/
├── .env.example
├── composer.json
├── package.json
└── README.md
```
---

## ⚙️ Getting Started

Follow these instructions to prepare a local development environment.

### Prerequisites

Make sure the following software is installed:

- PHP (compatible with the project's Laravel version).
- Composer.
- Node.js and npm.
- MySQL.
- Git.

### 1. Clone the Repository

```bash
git clone https://github.com/23DP2MPron/UniPlanner
```

Navigate into the project directory:

```bash
cd UniPlanner
```

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Configure Environment Variables

Create your local environment configuration:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

### 5. Configure the Database

Create a MySQL database for UniPlanner and update the database configuration in your `.env` file.

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. Start the Development Servers

Start the Laravel development server:

```bash
php artisan serve
```

Start the Vite development server in another terminal:

```bash
npm run dev
```

The local Laravel application is normally accessible at:

```text
http://127.0.0.1:8000
```

---

## 🔐 Environment Configuration

The `.env` file contains environment-specific configuration.

---

## 🗄 Database

UniPlanner uses MySQL as its relational database.

Potential database entities include:

| Entity | Description |
|---|---|
| Users | Application user accounts |
| Tasks | Academic and personal responsibilities |
| Events | Scheduled academic activities |
| Subjects | Academic subjects and courses |
| Timetable Entries | Recurring academic activities |
| Notifications | User reminders and notifications |

The final database schema is defined through Laravel migrations.

Database relationships and ownership rules must ensure that users can only access and modify records they are authorized to manage.

---

## 🔒 Security

Security and data integrity are important aspects of UniPlanner.

The application follows these development principles:

- Validate incoming requests on the backend.
- Use secure password hashing.
- Protect routes and restricted operations.
- Enforce user authorization.
- Prevent unauthorized access to personal records.
- Keep credentials outside source control.
- Use appropriate database constraints.
- Handle errors and invalid requests consistently.

Frontend validation should complement, not replace, backend validation.

---

## 🔄 Development Workflow

UniPlanner is developed collaboratively using Git.

Recommended workflow:

1. Create or select an issue describing the feature or bug.
2. Create a dedicated development branch.
3. Implement the required functionality.
4. Test the changes locally.
5. Commit changes with descriptive messages.
6. Open a Pull Request.
7. Review and integrate approved changes.

Branch naming:

```text
main
frontend
backend
```

---

## 👥 Team

UniPlanner is a collaborative university project developed by four students.

| Area | Responsibilities |
|---|---|
| Backend & Architecture | Laravel, API development, authentication, Docker |
| Frontend & UI | Vue.js, Vuetify, layouts, reusable components, documentation |
| Features & Database | Tasks, calendar, timetable, database relationships |
| Integration & Quality |  Laravel, API development, Testing, integration, Docker |

---

## 🚀 Future Improvements

Planned enhancements beyond the initial project scope include:

- External calendar synchronization.
- Advanced study analytics.
- Collaborative academic planning.
- Automated recurring task creation.
- Advanced notification settings.
- Email and browser notifications.
- Additional personalization options.

These features are future possibilities and are not a part of the initial MVP.

---

## 🎯 Project Vision

The goal of UniPlanner is to make academic planning easier, clearer, and more accessible.

By combining task management, scheduling, and academic organization in one platform, UniPlanner aims to help students spend less time managing their responsibilities and more time focusing on their education.

---

## 🌐 Access the Application

**UniPlanner — Live Deployment**

http://136.119.215.200
