# OBO - Office of Building Officials System

A comprehensive digital platform designed to modernize and streamline annual inspection processes for Local Government Units (LGU). The system provides efficient tools for managing inspections across multiple departments, ensuring compliance, transparency, and improved service delivery.

## 🏗️ System Overview

The OBO system is a web-based application built with PHP that manages building inspections across three main departments:
- **Electronics** - Electronic equipment inspections and compliance tracking
- **Electrical** - Electrical system inspections and safety protocols  
- **Mechanical** - Mechanical equipment maintenance and inspection management

## 🚀 Features

### Multi-Role System
- **System Admin** - Full system management and oversight
- **Department Inspectors** - Specialized inspection management for each department
- **Admin** - General administrative functions

### Core Functionality
- ✅ User authentication and role-based access control
- ✅ Dashboard with real-time metrics and statistics
- ✅ Inspector management system
- ✅ Inspection scheduling and tracking
- ✅ Comprehensive reporting system
- ✅ Mobile-responsive design
- ✅ Real-time notifications
- ✅ Data export capabilities

### Department-Specific Features
- **Mechanical Inspections** - Complete mechanical equipment inspection workflow
- **Electrical Inspections** - Electrical system compliance tracking
- **Electronics Inspections** - Electronic equipment inspection management

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Icons**: Font Awesome 6.0
- **Web Server**: Apache (XAMPP recommended)

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache Web Server
- XAMPP (recommended for local development)

## 🔧 Installation

### 1. Clone/Download the Project
```bash
# If using git
git clone <repository-url>
# Or download and extract to your web server directory
```

### 2. Database Setup
1. Create a MySQL database named `lgu_annual_inspection`
2. Update database configuration in `config/database.php`:
```php
return [
    'host' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'lgu_annual_inspection',
    'charset' => 'utf8'
];
```

### 3. Run Database Migrations
```bash
# Navigate to the project directory
cd /path/to/obo

# Run migrations via web browser
# Visit: http://localhost/obo/database/migrate.php

# Or via command line
php database/migrate.php
```

### 4. Configure Web Server
- Place the project in your web server's document root
- Ensure Apache mod_rewrite is enabled
- Set proper file permissions (755 for directories, 644 for files)

### 5. Access the Application
- Open your web browser
- Navigate to: `http://localhost/obo`
- Use the default login credentials (check database seeders)

## 📁 Project Structure

```
obo/
├── api/                    # API endpoints
│   ├── auth/              # Authentication APIs
│   ├── inspectors/        # Inspector management APIs
│   └── dashboard/         # Dashboard metrics APIs
├── config/                # Configuration files
│   └── database.php       # Database configuration
├── css/                   # Stylesheets
│   ├── fontawesome/       # Font Awesome icons
│   ├── index/            # Welcome page styles
│   ├── login/            # Login page styles
│   └── main.css          # Main application styles
├── database/              # Database files
│   ├── db.php            # Database connection
│   ├── migrate.php       # Migration runner
│   └── migrations/       # SQL migration files
├── images/                # Static images and assets
├── script/                # JavaScript files
│   ├── dashboard/        # Dashboard scripts
│   └── inspectors/       # Inspector management scripts
├── view/                  # View templates
│   ├── auth/             # Authentication views
│   ├── SystemAdmin_dashboard/  # System admin interface
│   └── inspectors/       # Inspector dashboards
└── index.php             # Welcome page
```

## 🔐 Default Users

After running migrations, the following default users are created:

| Username | Password | Role | Description |
|----------|----------|------|-------------|
| systemadmin | admin123 | systemadmin | System Administrator |
| mechanical | mech123 | mechanical | Mechanical Inspector |
| electrical | elec123 | electrical | Electrical Inspector |
| electronics | elec123 | electronics | Electronics Inspector |

## 🎯 User Roles & Permissions

### System Admin
- Full system access and management
- User and inspector management
- System-wide reports and analytics
- Department oversight

### Department Inspectors
- Department-specific inspection management
- Create and update inspections
- Generate department reports
- Manage inspection schedules

### Admin
- General administrative functions
- Basic user management
- Standard reporting

## 📊 API Endpoints

### Authentication
- `POST /api/auth/login.php` - User login
- `POST /api/auth/logout.php` - User logout
- `GET /api/auth/check_session.php` - Session validation

### Inspectors
- `GET /api/inspectors/get_inspectors.php` - Get all inspectors
- `GET /api/inspectors/get_inspector.php` - Get specific inspector
- `POST /api/inspectors/add_inspector.php` - Add new inspector
- `PUT /api/inspectors/update_inspector.php` - Update inspector
- `DELETE /api/inspectors/delete_inspector.php` - Delete inspector

### Dashboard
- `GET /api/dashboard/metrics.php` - Get dashboard metrics

## 🗄️ Database Schema

### Core Tables
- `users` - User accounts and roles
- `mechanical_inspections` - Mechanical inspection records
- `migrations` - Migration tracking

### Key Fields
- User management with role-based access
- Comprehensive inspection tracking
- Fee calculation and management
- Audit trails with timestamps

## 🎨 UI/UX Features

- **Responsive Design** - Works on desktop, tablet, and mobile
- **Modern Interface** - Clean, professional design
- **Interactive Dashboards** - Real-time data visualization
- **Intuitive Navigation** - Easy-to-use interface
- **Accessibility** - WCAG compliant design elements

## 🔧 Configuration

### Environment Variables
Create a `config/env.php` file for environment-specific settings:
```php
<?php
return [
    'DB_HOST' => 'localhost',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => '',
    'DB_NAME' => 'lgu_annual_inspection',
    'DB_CHARSET' => 'utf8'
];
```

### Security Settings
- Session management with secure cookies
- Password hashing (upgrade recommended)
- SQL injection prevention with prepared statements
- XSS protection with input sanitization

## 🚀 Deployment

### Production Deployment
1. Set up a production web server (Apache/Nginx)
2. Configure SSL certificate
3. Update database credentials
4. Set proper file permissions
5. Configure backup procedures
6. Enable error logging

### Performance Optimization
- Enable PHP OPcache
- Configure MySQL query cache
- Implement CDN for static assets
- Enable gzip compression

## 🧪 Testing

### Manual Testing
- Test all user roles and permissions
- Verify inspection workflows
- Check responsive design on different devices
- Validate form submissions and data integrity

### Security Testing
- Test authentication and authorization
- Verify SQL injection protection
- Check for XSS vulnerabilities
- Validate session management

## 📝 Development Guidelines

### Code Standards
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Implement proper error handling

### Database Best Practices
- Use prepared statements
- Implement proper indexing
- Regular database backups
- Monitor query performance

## 🐛 Troubleshooting

### Common Issues

**Database Connection Error**
- Check database credentials in `config/database.php`
- Ensure MySQL service is running
- Verify database exists

**Permission Denied**
- Check file permissions (755 for directories, 644 for files)
- Ensure web server has proper access

**Session Issues**
- Check PHP session configuration
- Verify session storage permissions
- Clear browser cookies

## 📞 Support

For technical support or questions:
- Check the troubleshooting section
- Review error logs
- Contact the development team

## 📄 License

This project is developed for Local Government Units and is intended for public service use.

## 🔄 Version History

- **v1.0** - Initial release with core functionality
- Multi-role system implementation
- Department-specific dashboards
- Basic inspection management

---

**Note**: This system is designed specifically for Local Government Units to streamline their annual inspection processes. Ensure compliance with local regulations and data protection requirements when deploying in production.



- You need to open php ini and change this to  'extension=zip'