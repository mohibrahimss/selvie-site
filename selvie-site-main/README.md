System Overview
Selvie is a mentor management platform built with Laravel 10, using Jetstream with Livewire and Teams functionality. The system facilitates mentor-student relationships, meeting management, and AI-powered assistance for educational support.
Technical Stack

PHP 8.2+
Laravel 10.x
Jetstream with Livewire
Teams functionality
MySQL/PostgreSQL
Redis (for queues and caching)
Laravel Echo (for real-time features)

Core System Components
1. Team Structure

Schools function as teams
Each team has multiple roles:

School Admin
Mentor
Support Staff


Team settings control school-specific configurations
Team invitations manage mentor onboarding

2. User Roles & Permissions

System uses Spatie Permission package
Roles are scoped to teams
Core roles:
Copy- Super Admin (system-wide)
- School Admin (team-specific)
- Mentor (team-specific)
- Support Staff (team-specific)


3. Database Structure
Core tables extend from Jetstream's team structure:
teams
  - schools
    - students
    - mentors
    - meetings
    - tasks
    - trainings
    - surveys

Model Relationships:
- School (extends Team):
  - Has many Students
  - Has many Mentors (through User model with role)
  - Has many Meetings
  - Has many Tasks
  - Has many Trainings

- Student:
  - Belongs to School
  - Belongs to many Mentors
  - Has many Meetings
  - Has many Tasks

- Mentor (User with Mentor role):
  - Belongs to many Schools (Teams)
  - Has many Students
  - Has many Meetings
  - Has many Tasks
  - Has many Trainings

- Meeting:
  - Belongs to School
  - Belongs to Mentor
  - Belongs to Student
  - Has many Tasks

- Task:
  - Belongs to School
  - Belongs to Meeting (optional)
  - Belongs to Student
  - Belongs to Mentor

- Training:
  - Belongs to School
  - Belongs to many Mentors (with completion tracking)

4. Queue System

Redis for queue management
Separate queues for:

Notifications
AI Processing
Data Import/Export
Report Generation



5. File Storage

S3 compatible storage for:

Student Documents
Training Materials
Generated Reports
Exported Data



Core Features Implementation
1. Authentication & Teams

Uses Jetstream authentication
Team invitation system
Role-based access control
Custom team dashboard

2. Student Management

Student profiles
Progress tracking
AI-generated plans
Document management

3. Meeting System

Calendar integration
Automated notifications
Meeting history
Attendance tracking

4. Task Management

Task assignment
Progress tracking
Due date monitoring
Automated reminders

5. Training Module

Content delivery
Progress tracking
Completion certificates
Resource management

AI Integration
1. OpenAI Integration

API connection management
Rate limiting
Error handling
Context management

2. AI Features

Student plan generation
Progress analysis
Recommendation engine
Help system routing

External Integrations
1. Data Sources

Google API integration
Ion Education connection
Innovare data sync
Custom data imports

2. Integration Requirements

API authentication
Data validation
Error handling
Sync scheduling

Development Guidelines
1. Code Organization
Copyapp/
  Http/
    Livewire/
      School/
      Student/
      Meeting/
      Task/
      Training/
  Services/
    AI/
    Integration/
    Notification/
  Models/
  Events/
  Listeners/

2. Brand Colors
Primary: #5b81c1 (Blue)
- Used for: Primary actions, navigation, headers
- Hover: #4a6da3
- Light: #edf1f7

Secondary: #f37863 (Coral)
- Used for: Call-to-actions, highlights, notifications
- Hover: #e1654f
- Light: #fef0ed

Usage:
- Tailwind classes: bg-primary, text-primary, bg-secondary, text-secondary
- Hover states: hover:bg-primary-hover, hover:bg-secondary-hover
- Light backgrounds: bg-primary-light, bg-secondary-light
- CSS Variables: var(--primary), var(--secondary)

3. Livewire Components

Use traits for common functionality
Implement loading states
Handle real-time updates
Maintain component isolation

4. Service Classes

Implement service layer pattern
Handle complex business logic
Manage external integrations
Process AI interactions

5. Event System

Use Laravel events for:

Notifications
AI processing
Data updates
Integration syncs