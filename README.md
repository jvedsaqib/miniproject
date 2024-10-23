# Placement Management System

<p align="center">
  <img src="https://avatars.githubusercontent.com/jvedsaqib?s=900" alt="Author Avatar" width="200" height="200" style="border-radius: 50%;">
</p>

<p align="center">
  Created by <a href="https://github.com/jvedsaqib">@jvedsaqib</a>
</p>

A comprehensive web-based system to manage the placement process, student records, and job postings for educational institutions.

## Features

### For Students
- Personal profile management
- View and apply for job postings
- Track application status
- Report issues with profile information
- View placement statistics
- Get email notifications for application updates

### For Administrators
- Manage student records
- Post and manage job opportunities
- Review student applications
- Handle student issues
- Post notices and announcements
- Generate placement reports and statistics

### General Features
- Secure login system
- Email verification
- Profile photo management
- Real-time notifications
- Responsive design
- Data validation and sanitization

## Technical Stack
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Email Service**: PHPMailer
- **Security**: Session management, SQL injection prevention

## Database Structure

Key tables include:
- `students`
- `admin`
- `job_posting`
- `applications`
- `placements`
- `issues`
- `notices`

## Installation

1. Clone the repository.
2. Import SQL schema from `QUERIES/table_create.sql`.
3. Configure the database connection in `php/connection.php`.
4. Set up email credentials in `php/mail_details.php`.
5. Deploy to a PHP-enabled web server.

## Security Features

- Password hashing
- Input sanitization
- Session management
- Role-based access control
- Secure file upload handling

## File Structure

```
├── css/
│   ├── nav.css
│   └── [other style files]
├── pages/
│   ├── admin/
│   ├── student/
│   ├── issues/
│   └── summary/
├── php/
│   ├── connection.php
│   ├── mail_details.php
│   └── phpmailer/
├── QUERIES/
│   ├── table_create.sql
│   └── placements.sql
└── README.md
```

## Authors

### Saqib Javed
- GitHub: [@jvedsaqib](https://github.com/jvedsaqib)
- Bio Site: [https://bio.site/jvedsaqib/](https://bio.site/jvedsaqib/)

Feel free to reach out for any questions or suggestions!
